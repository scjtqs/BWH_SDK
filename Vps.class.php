<?php
//namespace Vendor\scjtqs;
/**
 * Created by Zend Studio
 * User: scjtqs
 * Email: jose@scjtqs.cn
 * Date: 2016年6月30日
 * Time: 上午5:10:56
 */

/**
 * 版瓦工 接口控制类 
 * @category   ThinkPHP
 * @package  ThinkPHP
 * @subpackage  SDK
 * @author   Jose<jose@scjtqs.cn>
 */
class Vps{
    private $veid;
    private  $api_key;
    function __construct($veid,$api_key){
        $this->veid=$veid;
        $this->api_key=$api_key;
    }
    /**
     * 获取服务器信息
     * @access 
     * @return array
     *                vz_status: array consisting of OpenVZ beancounters, system load average, number of processes etc 
     *                 vz_quota: disk quota info 
     *                 is_cpu_throttled: 0 = CPU is not throttled, 1 = CPU is throttled due to high usage. Throttling resets automatically every 2 hours. 
     *                 ssh_port: SSH port of the VPS
     */
     function get_information(){
        $veid=$this->veid;
        $api_key=$this->api_key;
        $request = "https://api.64clouds.com/v1/getServiceInfo?veid={$veid}&api_key={$api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //设置host
    function set_host($hostname){
        $veid=$this->veid;
        $api_key=$this->api_key;
        $request = "https://api.64clouds.com/v1/setHostname?newHostname={$hostname}&veid={$veid}&api_key={$api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;       
    }
    //获取服务器运行信息
     function getLiveServiceInfo(){
        $veid=$this->veid;
        $api_key=$this->api_key;
        $request = "https://api.64clouds.com/v1/getLiveServiceInfo?veid={$veid}&api_key={$api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //获取使用量信息(月流量);
    function getRawUsageStats(){
        $request = "https://api.64clouds.com/v1/getRawUsageStats?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        //print_r ($serviceInfo);
    }
    //制作备份 create a snapshot
     function backup($description ){
        $request = "https://api.64clouds.com/v1/snapshot/create?description={$description}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        //print_r ($serviceInfo);
    }
    //获取备份列表
     function backup_list(){
        $request = "https://api.64clouds.com/v1/snapshot/list?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //还原备份
    function restore($snapshot){
        $request = "https://api.64clouds.com/v1/snapshot/restore?snapshot={$snapshot}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //导入备份
    function backpu_imp($out_veid,$out_token){
        $request = "https://api.64clouds.com/v1/snapshot/import?sourceVeid={$out_veid}&sourceToken={$out_token}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //删除备份
     function backup_del($snapshot){
        $request = "https://api.64clouds.com/v1/snapshot/delete?snapshot={$snapshot}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
       return $serviceInfo;
    }
    //共享备份
    function backup_exp($snapshot){
        $request = "https://api.64clouds.com/v1/snapshot/export?snapshot={$snapshot}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //重启VPS
     function restart(){
        $request = "https://api.64clouds.com/v1/restart?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //设置新的root密码 返回password:New root password
     function resetRootPassword(){
        $request = "https://api.64clouds.com/v1/resetRootPassword?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //获取能重装的可用系统列表
     function getAvailableOs(){
        $request = "https://api.64clouds.com/v1/getAvailableOS?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //重装系统
     function reinstallos($os){
        $request = "https://api.64clouds.com/v1/reinstallOS?os={$os}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    //Set PTR record
     function set_PTR($ip,$ptr){
        $request = "https://api.64clouds.com/v1/setPTR?ip={$ip}&ptr={$ptr}&veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request));
        return $serviceInfo;
    }
    //执行简单的shell命令
     function exec($command){
        //$request = "https://api.64clouds.com/v1/basicShell/exec?command={$command}&veid={$this->veid}&api_key={$this->api_key}";
        //$serviceInfo = json_decode (file_get_contents ($request),TRUE);
        $veid=$this->veid;
        $api_key=$this->api_key;
        $requestData = array ("veid" => $veid, "api_key" => $api_key,'command'=>$command);
        $request = "basicShell/exec";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.64clouds.com/v1/$request");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // curl running on Windows has issues with SSL -
        // see https://kb.ucla.edu/articles/how-do-i-use-curl-in-php-on-windows
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $jsonData = curl_exec($ch);
        if (curl_error($ch)) die("Connection Error: ".curl_errno($ch)." - ".curl_error($ch));
        curl_close($ch);
        $serviceInfo=json_decode ($jsonData,TRUE);
        return $serviceInfo;
    }
    function getRateLimitStatus(){
        $request = "https://api.64clouds.com/v1/getRateLimitStatus?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    /*
     * 启动vps
     * */
    function start(){
        $request = "https://api.64clouds.com/v1/start?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    /*
     * 关闭VPS
     * */
    function stop(){
        $request = "https://api.64clouds.com/v1/stop?veid={$this->veid}&api_key={$this->api_key}";
        $serviceInfo = json_decode (file_get_contents ($request),TRUE);
        return $serviceInfo;
    }
    
}