<?php

namespace ThemisMin\LaravelMgo\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use ThemisMin\LaravelMgo\Models\MgoColumn;
use ThemisMin\LaravelMgo\Models\MgoModule;
use ThemisMin\LaravelMgo\Models\MgoTable;

trait MgoTrait
{

    /**
     * 搜索字段
     * @param MgoModule|Collection $mgoModule 定义模块
     * @param array $attrColumns 搜索配置
     * @return array
     */
    protected function searchColumns(MgoModule $mgoModule, array $attrColumns)
    {
        /** @var MgoColumn[]|Collection $mgoColumns 定义列属性 */
        $mgoColumns = $mgoModule->mgoTable->mgoColumns;

        /** @var MgoColumn[]|Collection $mgoColumns 搜索配置 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            $searchMgoColumns = $mgoColumns->whereIn('name', $columns);
        } else {
            $searchMgoColumns = collect([]);
        }

        $searchColumns = [];
        foreach ($searchMgoColumns as $searchMgoColumn) {
            /** @var MgoColumn|Collection $searchMgoColumn */
            $searchColumns[] = [
                'title' => $searchMgoColumn->display_name,
                'key' => $searchMgoColumn->name,
                'data_type' => $searchMgoColumn->data_type,
                'data_values' => $this->dataValues($searchMgoColumn),
            ];;
        }
        return $searchColumns;
    }

    /**
     * 列字段
     * @param MgoModule|Collection $mgoModule 定义模块
     * @param array $attrColumns 列配置
     * @return array
     */
    protected function listColumns(MgoModule $mgoModule, array $attrColumns)
    {
        /** @var MgoTable|Collection $mgoTable 定义表 */
        $mgoTable = $mgoModule->mgoTable;
        /** @var MgoColumn[]|Collection $mgoColumns 定义列 */
        $mgoColumns = $mgoTable->mgoColumns;

        /** @var MgoColumn[]|array $listMgoColumns 列表显示字段 */
        if ($attrColumns) {
            $columns = collect($attrColumns)->pluck(['column'])->toArray();
            in_array('id', $columns) ?: $columns = array_merge(['id'], $columns);
            // 列展示正序排列
            $listMgoColumns = $mgoColumns->sortBy('order_by')->whereIn('name', $columns);
        } else {
            $listMgoColumns = $mgoColumns;
        }

        $listColumns = [];
        foreach ($listMgoColumns as $listMgoColumn) {
            /** @var MgoColumn|Collection $listMgoColumn */
            $listColumns[] = [
                'title' => $listMgoColumn->display_name,
                'key' => $listMgoColumn->name,
                // 'data_type' => $listMgoColumn->data_type,
                // 'data_values' => $this->dataValues($listMgoColumn),
            ];
        }
        return $listColumns;
    }

    /**
     * 数据
     * @param MgoColumn $mgoColumn
     * @return array|\Illuminate\Database\Eloquent\Collection|Collection|\ThemisMin\LaravelMgo\Models\MgoEnumValue[]|null
     */
    protected function dataValues(MgoColumn $mgoColumn)
    {
        switch ($mgoColumn->data_type) {
            case 'enum':
                return $mgoColumn->mgoEnumValues->map(function ($item) {
                    return [
                        'title' => $item->display_name,
                        'key' => $item->name,
                    ];
                });
                break;
            case 'belongs_to':
                return [
                    'mgo_table_id' => $mgoColumn->mgoForeign->referencedMgoTable->id,
                    'mgo_column_id' => $mgoColumn->mgoForeign->referenced_mgo_column_id,
                ];
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * TODO:: 规则
     */
    protected function rules()
    {

    }

    /**
     * 计算 COS API 请求用的签名
     * @param $keys
     * @param $method
     * @param $pathname
     * @param array $query
     * @param array $headers
     * @return string
     */
    protected function _getAuthorization($keys, $method, $pathname, $query = array(), $headers = array())
    {
        // 获取个人 API 密钥 https://console.qcloud.com/capi
        $SecretId = $keys['credentials']['tmpSecretId'];
        $SecretKey = $keys['credentials']['tmpSecretKey'];
        // 整理参数
        $query = array();
        $headers = array();
        $method = strtolower($method ? $method : 'get');
        $pathname = $pathname ? $pathname : '/';
        substr($pathname, 0, 1) != '/' && ($pathname = '/' . $pathname);
        // 工具方法
        function getObjectKeys($obj)
        {
            $list = array_keys($obj);
            sort($list);
            return $list;
        }

        function obj2str($obj)
        {
            $list = array();
            $keyList = getObjectKeys($obj);
            $len = count($keyList);
            for ($i = 0; $i < $len; $i++) {
                $key = $keyList[$i];
                $val = isset($obj[$key]) ? $obj[$key] : '';
                $key = strtolower($key);
                $list[] = rawurlencode($key) . '=' . rawurlencode($val);
            }
            return implode('&', $list);
        }

        // 签名有效起止时间
        $now = time() - 1;
        $expired = $now + 600; // 签名过期时刻，600 秒后
        // 要用到的 Authorization 参数列表
        $qSignAlgorithm = 'sha1';
        $qAk = $SecretId;
        $qSignTime = $now . ';' . $expired;
        $qKeyTime = $now . ';' . $expired;
        $qHeaderList = strtolower(implode(';', getObjectKeys($headers)));
        $qUrlParamList = strtolower(implode(';', getObjectKeys($query)));
        // 签名算法说明文档：https://www.qcloud.com/document/product/436/7778
        // 步骤一：计算 SignKey
        $signKey = hash_hmac("sha1", $qKeyTime, $SecretKey);
        // 步骤二：构成 FormatString
        $formatString = implode("\n", array(strtolower($method), $pathname, obj2str($query), obj2str($headers), ''));
        // 步骤三：计算 StringToSign
        $stringToSign = implode("\n", array('sha1', $qSignTime, sha1($formatString), ''));
        // 步骤四：计算 Signature
        $qSignature = hash_hmac('sha1', $stringToSign, $signKey);
        // 步骤五：构造 Authorization
        $authorization = implode('&', array(
            'q-sign-algorithm=' . $qSignAlgorithm,
            'q-ak=' . $qAk,
            'q-sign-time=' . $qSignTime,
            'q-key-time=' . $qKeyTime,
            'q-header-list=' . $qHeaderList,
            'q-url-param-list=' . $qUrlParamList,
            'q-signature=' . $qSignature
        ));
        return $authorization;
    }

    /**
     * 获取临时密钥
     * @param $config
     * @return mixed|string
     */
    protected function _getTempKeys($config)
    {
        // 判断是否修改了 AllowPrefix
        if ($config['AllowPrefix'] === '_ALLOW_DIR_/*') {
            return array('error' => '请修改 AllowPrefix 配置项，指定允许上传的路径前缀');
        }
        $ShortBucketName = substr($config['Bucket'], 0, strripos($config['Bucket'], '-'));
        $AppId = substr($config['Bucket'], 1 + strripos($config['Bucket'], '-'));
        $policy = array(
            'version' => '2.0',
            'statement' => array(
                array(
                    'action' => array(
                        // // 这里可以从临时密钥的权限上控制前端允许的操作
                        // 'name/cos:*', // 这样写可以包含下面所有权限
                        // // 列出所有允许的操作
                        // // ACL 读写
                        // 'name/cos:GetBucketACL',
                        // 'name/cos:PutBucketACL',
                        // 'name/cos:GetObjectACL',
                        // 'name/cos:PutObjectACL',
                        // // 简单 Bucket 操作
                        // 'name/cos:PutBucket',
                        // 'name/cos:HeadBucket',
                        // 'name/cos:GetBucket',
                        // 'name/cos:DeleteBucket',
                        // 'name/cos:GetBucketLocation',
                        // // Versioning
                        // 'name/cos:PutBucketVersioning',
                        // 'name/cos:GetBucketVersioning',
                        // // CORS
                        // 'name/cos:PutBucketCORS',
                        // 'name/cos:GetBucketCORS',
                        // 'name/cos:DeleteBucketCORS',
                        // // Lifecycle
                        // 'name/cos:PutBucketLifecycle',
                        // 'name/cos:GetBucketLifecycle',
                        // 'name/cos:DeleteBucketLifecycle',
                        // // Replication
                        // 'name/cos:PutBucketReplication',
                        // 'name/cos:GetBucketReplication',
                        // 'name/cos:DeleteBucketReplication',
                        // // 删除文件
                        // 'name/cos:DeleteMultipleObject',
                        // 'name/cos:DeleteObject',
                        // 简单文件操作
                        'name/cos:PutObject',
                        'name/cos:PostObject',
                        'name/cos:AppendObject',
                        'name/cos:GetObject',
                        'name/cos:HeadObject',
                        'name/cos:OptionsObject',
                        'name/cos:PutObjectCopy',
                        'name/cos:PostObjectRestore',
                        // 分片上传操作
                        'name/cos:InitiateMultipartUpload',
                        'name/cos:ListMultipartUploads',
                        'name/cos:ListParts',
                        'name/cos:UploadPart',
                        'name/cos:CompleteMultipartUpload',
                        'name/cos:AbortMultipartUpload',
                    ),
                    'effect' => 'allow',
                    'principal' => array('qcs' => array('*')),
                    'resource' => array(
                        'qcs::cos:' . $config['Region'] . ':uid/' . $AppId . ':prefix//' . $AppId . '/' . $ShortBucketName . '/',
                        'qcs::cos:' . $config['Region'] . ':uid/' . $AppId . ':prefix//' . $AppId . '/' . $ShortBucketName . '/' . $config['AllowPrefix']
                    )
                )
            )
        );
        $policyStr = str_replace('\\/', '/', json_encode($policy));
        // 有效时间小于 30 秒就重新获取临时密钥，否则使用缓存的临时密钥
        $redisName = config('common.redis_key.cos_temp_keys_cache.connection');
        $redisIndex = config('common.redis_key.cos_temp_keys_cache.index');
        $redis = Redis::connection($redisName);
        $tempKeysCache = $redis->get($redisIndex);
        if ($tempKeysCache) {
            $tempKeysCache = json_decode($tempKeysCache, true);
            if ($tempKeysCache['policyStr'] == $policyStr) {
                return $tempKeysCache;
            }
        }

        $Action = 'GetFederationToken';
        $Nonce = rand(10000, 20000);
        $Timestamp = time() - 1;
        $Method = 'POST';
        $params = array(
            'Region' => 'gz',
            'SecretId' => $config['SecretId'],
            'Timestamp' => $Timestamp,
            'Nonce' => $Nonce,
            'Action' => $Action,
            'durationSeconds' => 7200,
            'name' => 'cos',
            'policy' => urlencode($policyStr)
        );
        $params['Signature'] = $this->_getSignature($params, $config['SecretKey'], $Method, $config['Domain']);
        $url = $config['Url'];
        $ch = curl_init($url);
        $config['Proxy'] && curl_setopt($ch, CURLOPT_PROXY, $config['Proxy']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_json2str($params));
        $result = curl_exec($ch);
        if (curl_errno($ch)) $result = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, 1);
        if (isset($result['data'])) $result = $result['data'];
        $data = $result;
        $data['policyStr'] = $policyStr;
        $redis->setex($redisIndex, 30, json_encode($data));
        return $result;
    }

    /**
     * 计算临时密钥用的签名
     * @param $opt
     * @param $key
     * @param $method
     * @return string
     */
    protected function _getSignature($opt, $key, $method, $domain)
    {
        $formatString = $method . $domain . '/v2/index.php?' . $this->_json2str($opt, 1);
        $sign = hash_hmac('sha1', $formatString, $key);
        $sign = base64_encode($this->_hex2bin($sign));
        return $sign;
    }

    /**
     * 转码
     * @param $data
     * @return string
     */
    protected function _hex2bin($data)
    {
        $len = strlen($data);
        return pack("H" . $len, $data);
    }

    /**
     * obj 转 query string
     * @param $obj
     * @param bool $notEncode
     * @return string
     */
    protected function _json2str($obj, $notEncode = false)
    {
        ksort($obj);
        $arr = array();
        foreach ($obj as $key => $val) {
            array_push($arr, $key . '=' . ($notEncode ? $val : rawurlencode($val)));
        }
        return join('&', $arr);
    }

}