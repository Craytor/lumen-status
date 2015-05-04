<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller {

	// Holy crap these functions needs some extreme organizing and reusability

	public function __construct()
	{
		$this->uptime_initial = shell_exec("cut -d. -f1 /proc/uptime");

	}

	public function index()
	{
		
	    } else {
	        $uptime = "Error retreving uptime.";
	    }


	    // Check disk stats
	    $disk_result = `df -P | grep /dev/$`;
	    if(!trim($disk_result)) {
	        $disk_result = `df -P | grep /$`;
	    }
	    $disk_result = explode(" ", preg_replace("/\s+/", " ", $disk_result));
	    $disk_total = intval($disk_result[1]);
	    $disk_used = intval($disk_result[2]);
	    $disk = intval(rtrim($disk_result[4], "%"));


	    // Check current RAM usage
	    $mem_result = trim(`free -mo | grep Mem`);
	    $mem_result = explode(" ", preg_replace("/\s+/", " ", $mem_result));
	    $mem_total = intval($mem_result[1]);
	    $mem_used = $mem_result[2] - $mem_result[5] - $mem_result[6];
	    $memory = round($mem_used / $mem_total * 100);


	    // Check current swap usage
	    $swap_result = trim(`free -mo | grep Swap`);
	    $swap_result = explode(" ", preg_replace("/\s+/", " ", $swap_result));
	    $swap_total = $swap_result[1];
	    $swap_used = $swap_result[2];
	    $swap = round($swap_used / $swap_total * 100);

	    $num_cpus = 1;
	    if (is_file('/proc/cpuinfo')) {
	        $cpuinfo = file_get_contents('/proc/cpuinfo');
	        preg_match_all('/^processor/m', $cpuinfo, $matches);
	        $num_cpus = count($matches[0]);
	    } else {
	        $process = @popen('sysctl -a', 'rb');
	        if (false !== $process) {
	            $output = stream_get_contents($process);
	            preg_match('/hw.ncpu: (\d+)/', $output, $matches);
	            if ($matches) {
	                $num_cpus = intval($matches[1][0]);
	            }
	            pclose($process);
	        }
	    }


		if(function_exists("sys_getloadavg")) {
            $load = sys_getloadavg();
            $cpu = $load[0] * 100 / $num_cpus;
        } elseif(`which uptime`) {
            $str = substr(strrchr(`uptime`,":"),1);
            $avs = array_map("trim",explode(",",$str));
            $cpu = $avs[0] * 100 / $num_cpus;
        } elseif(`which mpstat`) {
            $cpu = 100 - round(`mpstat 1 2 | tail -n 1 | sed 's/.*\([0-9\.+]\{5\}\)$/\\1/'`);
        } elseif(is_file('/proc/loadavg')) {
            $cpu = 0;
            $output = `cat /proc/loadavg`;
            $cpu = substr($output,0,strpos($output," "));
        } else {
            $cpu = 0;
        }

        $data = array(
	        'uptime' => $uptime,
	        'disk' => $disk,
	        'disk_total' => $disk_total,
	        'disk_used' => $disk_used,
	        'cpu' => $cpu,
	        'num_cpus' => $num_cpus,
	        'memory' => $memory,
	        'memory_total' => $mem_total,
	        'memory_used' => $mem_used,
	        'swap' => $swap,
	        'swap_total' => $swap_total,
	        'swap_used' => $swap_used
    	);

		return view('default', $data);

	}

	public function data()
	{
	    } else {
	        $uptime = "Error retreving uptime.";
	    }


	    // Check disk stats
	    $disk_result = `df -P | grep /dev/$`;
	    if(!trim($disk_result)) {
	        $disk_result = `df -P | grep /$`;
	    }
	    $disk_result = explode(" ", preg_replace("/\s+/", " ", $disk_result));
	    $disk_total = intval($disk_result[1]);
	    $disk_used = intval($disk_result[2]);
	    $disk = intval(rtrim($disk_result[4], "%"));


	    // Check current RAM usage
	    $mem_result = trim(`free -mo | grep Mem`);
	    $mem_result = explode(" ", preg_replace("/\s+/", " ", $mem_result));
	    $mem_total = intval($mem_result[1]);
	    $mem_used = $mem_result[2] - $mem_result[5] - $mem_result[6];
	    $memory = round($mem_used / $mem_total * 100);


	    // Check current swap usage
	    $swap_result = trim(`free -mo | grep Swap`);
	    $swap_result = explode(" ", preg_replace("/\s+/", " ", $swap_result));
	    $swap_total = $swap_result[1];
	    $swap_used = $swap_result[2];
	    $swap = round($swap_used / $swap_total * 100);

	    $num_cpus = 1;
	    if (is_file('/proc/cpuinfo')) {
	        $cpuinfo = file_get_contents('/proc/cpuinfo');
	        preg_match_all('/^processor/m', $cpuinfo, $matches);
	        $num_cpus = count($matches[0]);
	    } else {
	        $process = @popen('sysctl -a', 'rb');
	        if (false !== $process) {
	            $output = stream_get_contents($process);
	            preg_match('/hw.ncpu: (\d+)/', $output, $matches);
	            if ($matches) {
	                $num_cpus = intval($matches[1][0]);
	            }
	            pclose($process);
	        }
	    }


		if(function_exists("sys_getloadavg")) {
            $load = sys_getloadavg();
            $cpu = $load[0] * 100 / $num_cpus;
        } elseif(`which uptime`) {
            $str = substr(strrchr(`uptime`,":"),1);
            $avs = array_map("trim",explode(",",$str));
            $cpu = $avs[0] * 100 / $num_cpus;
        } elseif(`which mpstat`) {
            $cpu = 100 - round(`mpstat 1 2 | tail -n 1 | sed 's/.*\([0-9\.+]\{5\}\)$/\\1/'`);
        } elseif(is_file('/proc/loadavg')) {
            $cpu = 0;
            $output = `cat /proc/loadavg`;
            $cpu = substr($output,0,strpos($output," "));
        } else {
            $cpu = 0;
        }

        $data = array(
	        'uptime' => $uptime,
	        'disk' => $disk,
	        'disk_total' => $disk_total,
	        'disk_used' => $disk_used,
	        'cpu' => $cpu,
	        'num_cpus' => $num_cpus,
	        'memory' => $memory,
	        'memory_total' => $mem_total,
	        'memory_used' => $mem_used,
	        'swap' => $swap,
	        'swap_total' => $swap_total,
	        'swap_used' => $swap_used
    	);

    	return response($data);

	}

}