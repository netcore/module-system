<?php

if (!function_exists('formatBytes')) {

    /**
     * @param $size
     * @return string
     */
    function formatBytes($size)
    {
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

}

if (!function_exists('systemLoad')) {

    /**
     * @param int $coreCount
     * @param int $interval
     * @return float
     */
    function systemLoad($coreCount = 2, $interval = 1)
    {
        $rs = sys_getloadavg();
        $interval = $interval >= 1 && 3 <= $interval ? $interval : 1;
        $load = $rs[$interval];
        return round(($load * 100) / $coreCount, 2);
    }
}

if (!function_exists('systemCoreCount')) {

    /**
     * @return int
     */
    function systemCoreCount()
    {

        $cmd = "uname";
        $OS = strtolower(trim(shell_exec($cmd)));

        switch ($OS) {
            case('linux'):
                $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
                break;
            case('freebsd'):
                $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
                break;
            default:
                unset($cmd);
        }

        if ($cmd != '') {
            $cpuCoreNo = intval(trim(shell_exec($cmd)));
        }

        return empty($cpuCoreNo) ? 1 : $cpuCoreNo;

    }
}

if (!function_exists('serverMemoryUsage')) {

    /**
     * @return float|int
     */
    function serverMemoryUsage()
    {

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2] / $mem[1] * 100;

        return $memory_usage;
    }
}

if (!function_exists('core')) {

    /**
     * @return \Illuminate\Foundation\Application|mixed|\Modules\System\Repositories\SystemRepository|SystemRepository
     */
    function core()
    {
        return app('SystemRepository');
    }
}