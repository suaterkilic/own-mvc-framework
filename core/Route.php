<?php

class Route
{
    public static function parse_url()
    {
        $dirname = basename($_SERVER['SCRIPT_NAME']);
        $basename = basename($_SERVER['SCRIPT_NAME']);
        
        return $request_uri = str_replace([$dirname, $basename], null, $_SERVER['REQUEST_URI']);
    }

    public static function get($url, $callback, $method = 'get')
    {

        $req_uri = self::parse_url();
        $params;
        $pattern = 
        [
            '{id}' => '([0-9]+)',
            '{url}' => '([0-9a-zA-Z]+)'
        ];

        $url_arr = explode('/', $url);
        $req_arr = explode('/', $req_uri);

        $req_arr_count = count($req_arr);

        $req_arr_id;

        if(in_array('{id}', $url_arr))
        {
            $url = str_replace(array_keys($pattern), array_values($pattern), $url);

            for($i = 0; $i < $req_arr_count; $i++ )
            {
                if(preg_match($pattern['{id}'], $req_arr[$i]))
                {
                    $req_arr_id = $req_arr[$i];
                    break;
                }
            }
            @$params = $req_arr_id;
        }
        else
        {
            $params = $url;
        }

        if(preg_match('@^' . $url . '$@', $req_uri, $parameters))
        {
            $controller = explode('@', $callback);

            $controller_name = $controller[0];
            $action_name = $controller[1];


            $controllerFile = 'app/controllers/'. $controller_name . '.php';

            if(file_exists($controllerFile))
            {
                require $controllerFile;

                call_user_func_array([new $controller_name, $action_name], array($params));
            }
        }
        
    }

    public static function post($url, $callback, $method = 'post')
    {
        $req_uri = self::parse_url();
        $pattern = '([0-9a-zA-Z]+)';

        if($url == $req_uri)
        {
            $controller = explode('@', $callback);
            
            $controller_name = $controller[0];
            $action_name = $controller[1];

            $controllerFile = 'app/controllers/' . $controller_name . '.php';

            if(file_exists($controllerFile))
            {
                require_once $controllerFile;

                call_user_func_array([new $controller_name, $action_name], array($url));
            }
        }
    }

    public static function put($url, $callback, $method = 'post')
    {

        $req_uri = self::parse_url();
        $params;
        $pattern = 
        [
            '{id}' => '([0-9]+)',
            '{url}' => '([0-9a-zA-Z]+)'
        ];

        $url_arr = explode('/', $url);
        $req_arr = explode('/', $req_uri);

        $req_arr_count = count($req_arr);

        $req_arr_id;

        if(in_array('{id}', $url_arr))
        {
            $url = str_replace(array_keys($pattern), array_values($pattern), $url);

            for($i = 0; $i < $req_arr_count; $i++ )
            {
                if(preg_match($pattern['{id}'], $req_arr[$i]))
                {
                    $req_arr_id = $req_arr[$i];
                    break;
                }
            }
            @$params = $req_arr_id;
            
            if(preg_match('@^' . $url . '$@', $req_uri, $parameters))
            {
                $controller = explode('@', $callback);
    
                $controller_name = $controller[0];
                $action_name = $controller[1];
    
    
                $controllerFile = 'app/controllers/'. $controller_name . '.php';
    
                if(file_exists($controllerFile))
                {
                    require $controllerFile;
    
                    call_user_func_array([new $controller_name, $action_name], array($params));
                }
            }
        }

        
    }

    public static function delete($url, $callback, $method = 'get')
    {

        $req_uri = self::parse_url();
        $params;
        $pattern = 
        [
            '{id}' => '([0-9]+)',
            '{url}' => '([0-9a-zA-Z]+)'
        ];

        $url_arr = explode('/', $url);
        $req_arr = explode('/', $req_uri);

        $req_arr_count = count($req_arr);

        $req_arr_id;

        if(in_array('{id}', $url_arr))
        {
            $url = str_replace(array_keys($pattern), array_values($pattern), $url);

            for($i = 0; $i < $req_arr_count; $i++ )
            {
                if(preg_match($pattern['{id}'], $req_arr[$i]))
                {
                    $req_arr_id = $req_arr[$i];
                    break;
                }
            }
            @$params = $req_arr_id;
            
            if(preg_match('@^' . $url . '$@', $req_uri, $parameters))
            {
                $controller = explode('@', $callback);
    
                $controller_name = $controller[0];
                $action_name = $controller[1];
    
    
                $controllerFile = 'app/controllers/'. $controller_name . '.php';
    
                if(file_exists($controllerFile))
                {
                    require $controllerFile;
    
                    call_user_func_array([new $controller_name, $action_name], array($params));
                }
            }
        }
    }
}
