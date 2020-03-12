<?php
use Jenssegers\Blade\Blade;
if (!function_exists('view')) {
    function view($view, $data = []) {
        $path = APPPATH.'views';
        $blade = new Blade($path, $path . '/cache');
        if(isset($_SESSION[KEY_USER])){
            $user = $_SESSION[KEY_USER];
            $blade->share('isSuperadmin', ($user['group']->group_id == GROUP_SUPERADMIN || $user['group']->group_id == GROUP_MABES));
            
        }
        echo $blade->make($view, $data);
    }
}
?>