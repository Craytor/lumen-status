<html>
    <head>
        <meta charset="utf-8">
        <title>{{ env('LS__SERVER_NAME', 'Server Name') }}</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jqknob.js"></script>
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/style.css" />
        <style>
            #wrapper {
                background-image: url(" {{ env('LS__server_background', 'http://shots.tjyouschak.me/1dQE') }} ");
            }
        </style>
        <script>
            function update() {
                $.get('data', function(data) {
                    // Update footer
                    $('#uptime').text(data.uptime);
                    $('#k-cpu').val(data.cpu).trigger("change");
                    $('#k-memory').val(data.memory).trigger("change");
                    if(data.swap_total) {
                        $('#k-swap').val(data.swap).trigger("change");
                    }
                    // Update details
                    $('#dt-disk-used').text(Math.round(data.disk_used / 10485.76) / 100);
                    $('#dt-mem-used').text(data.memory_used);
                    $('#dt-num-cpus').text(data.num_cpus);
                    if(data.swap_total) {
                        $('#dt-swap_used').text(data.swap_used);
                    }
                    window.setTimeout(update, 3000);
                },'json');
            }
            $(document).ready(function() {
                // Show ring charts
                $("#k-disk, #k-memory, #k-swap, #k-cpu").knob({
                    readOnly: true,
                    width: 40,
                    height: 40,
                    thickness: 0.2,
                    fontWeight: 'normal',
                    bgColor: 'rgba(127,127,127,0.15)', // 50% grey with a low opacity, should work with most backgrounds
                    fgColor: '#ccc'
                });
                // Start AJAX update loop
                update();
            });
        </script>
    </head>
    <body>
        <div class="menu push-menu-bottom">
            <div class="left">
                <h2>{{ env('LS__SERVER_NAME', 'Server Name') }}</h2>
                IP Will go here

            </div>
            <div class="right">
                <b>Disk:</b> <span id="dt-disk-used">{{ round($disk_used / 1048576, 2) }}</span> GB / {{ round($disk_total / 1048576, 2) }} GB<br>
                <b>Memory:</b> <span id="dt-mem-used">{{ round($memory_used) }}</span> MB / {{ (512 * round(round($memory_used) / 512)) }} MB<br>

                @if($swap_total !== "0")
                    <b>Swap:</b> <span id="dt-swap-used">{{ $swap_used }}</span> MB / {{ $swap_total }} MB<br>
                @else
                    <b>Swap:</b> N/A<br>
                @endif

                <b>CPU Cores:</b> <span id="dt-num-cpus"></span>
            </div>
        </div><!-- /push menu bottom -->
        <div id="wrapper">
            <h1>{{ env('LS__SERVER_NAME', 'Server Name') }}</h1>
            <p>{{ env('LS__SERVER_DESCRIPTION', 'Description') }}</p>
            <footer>
                <div class="left">
                    @if(!empty($uptime))
                        Uptime: <span id="uptime">{{ $uptime }}</span>&emsp;
                    @endif
                    Disk usage: <input id="k-disk" value="{{ $disk }}">&emsp;
                    Memory: <input id="k-memory" value="{{ $memory }}">&emsp;
                    @if($swap_total !== "0")
                        Swap: <input id="k-swap" value="{{ $swap }}">&emsp;
                    @endif
                    CPU: <input id="k-cpu" value="0">&emsp;
                </div>
                <div class="right">
                    <button class="nav-toggler toggle-push-bottom">Additional Information</button>
                </div>
            </footer>
        </div>
        <script src="js/application.js"></script>
    </body>
</html>