<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller {

	// Holy crap these functions needs some extreme organizing and reusability

	public function __construct()
	{
		$this->uptime_initial = shell_exec("cut -d. -f1 /proc/uptime");
		$this->uptime_days = floor($this->uptime_initial / 60 / 60 / 24);
		$this->uptime_hours = $this->uptime_initial / 60 / 60 % 24;
		$this->uptime_mins = $this->uptime_initial / 60 % 60;
		$this->uptime_secs = $this->uptime_initial % 60;

		$this->mem_data = explode(" ", preg_replace("/\s+/", " ", trim(`free -mo | grep Mem`)));
		$this->mem_total = intval($this->mem_data[1]);
		$this->mem_used = $this->mem_data[2] - $this->mem_data[5] - $this->mem_data[6];

		$this->swap_data = explode(" ", preg_replace("/\s+/", " ", trim(`free -mo | grep Swap`)));
		$this->swap_total = $this->swap_data[1];
		$this->swap_used = $this->swap_data[2];

	}

	public function index()
	{
		
	    if($this->uptime_days > "0") {
	        $uptime = $this->uptime_days . "d " . $this->uptime_hours . "h";
	    } elseif ($this->uptime_days == "0" && $this->uptime_hours > "0") {
	        $uptime = $this->uptime_hours . "h " . $this->uptime_mins . "m";
	    } elseif ($this->uptime_hours == "0" && $this->uptime_mins > "0") {
	        $uptime = $this->uptime_mins . "m " . $this->uptime_secs . "s";
	    } elseif ($this->uptime_mins < "0") {
	        $uptime = $this->uptime_secs . "s";
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

	    $memory = 0;
	    if($this->mem_used == "0" || $this->mem_total == "0") {
	    	$memory = round($this->mem_used / $this->mem_total * 100);
		}

		$swap = 0;
		if($this->swap_used == "0" || $this->swap_total == "0") {
	    	$swap = round($this->swap_used / $this->swap_total * 100);
		}



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
	        'memory_total' => $this->mem_total,
	        'memory_used' => $this->mem_used,
	        'swap' => $swap,
	        'swap_total' => $this->swap_total,
	        'swap_used' => $this->swap_used
    	);

		return view('default', $data);

	}

	public function data()
	{
		if($this->uptime_days > "0") {
	        $uptime = $this->uptime_days . "d " . $this->uptime_hours . "h";
	    } elseif ($this->uptime_days == "0" && $this->uptime_hours > "0") {
	        $uptime = $this->uptime_hours . "h " . $this->uptime_mins . "m";
	    } elseif ($this->uptime_hours == "0" && $this->uptime_mins > "0") {
	        $uptime = $this->uptime_mins . "m " . $this->uptime_secs . "s";
	    } elseif ($this->uptime_mins < "0") {
	        $uptime = $this->uptime_secs . "s";
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


	    
	    if($this->mem_used == "0" || $this->mem_total == "0") {
	    	$memory = round($this->mem_used / $this->mem_total * 100);
		} else {
			$memory = 0;
		}

		
		if($this->swap_used == "0" || $this->swap_total == "0") {
	    	$swap = round($this->swap_used / $this->swap_total * 100);
		} else {
			$swap = 0;
		}


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
	        'memory_total' => $this->mem_total,
	        'memory_used' => $this->mem_used,
	        'swap' => $swap,
	        'swap_total' => $this->swap_total,
	        'swap_used' => $this->swap_used
    	);

    	return response($data);

	}

}