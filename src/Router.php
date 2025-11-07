<?php
namespace spl2025; 

/**
 * ルーター(Router)　
 */
class Router
{
    private $base = null; 
    private $rules = [];
    
    public function __construct($base, $rules)
    {
        $this->base = $base;
        $this->rules = ['GET'=>[],'POST'=>[]];
        foreach ($rules as $rule) {
            $method = strtoupper($rule[0]);
            $rule = ['pattern'=>$rule[1], 'def'=>$rule[2], 'params'=>$rule[3]??[]];
            array_push($this->rules[$method], $rule);
        }
    }
  
    public function match($method, $request)
    {
        $method = strtoupper($method);
        foreach ($this->rules[$method]??[] as $rule) {
            $params = [];
            $pattern = rtrim($this->base, '/') . $rule['pattern'];
    
            if (preg_match("#^{$pattern}/?$#", $request, $matches)) {
                foreach ($rule['params'] as $i=>$name){
                    $params[$name] = $matches[$i+1] ?? null;
                }
                return ['c'=>$rule['def']['c'],'a'=>$rule['def']['a'],'p'=>$params];
            }
        }
        return null;
    }
}