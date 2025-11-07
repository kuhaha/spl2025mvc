<?php
namespace spl2025\controllers; 

/**
 * コントローラー（Controller）のベースとなるクラス
 */
abstract class Controller 
{
    const ERROR=[
      '300' =>'無効なリクエスト',
      '301' => 'データが存在しません',
      '400' =>'ファイルやパスが存在しません',
      '901'=>'パスワードが一致しません',
      '902'=>'必須パラメータが与えられていません',
    ];

    protected $model;
    protected $view;

    public function __construct($model, $view)
    {
      $this->model = $model;
      $this->view = $view;
    }
    public function model()
    {
      return $this->model;
    }
    public function view()
    {
      return $this->view;
    }

    public function errorAction($msg)
    {
      $err_msg = self::ERROR[$msg] ?? '何かエラーが発生しました';
      return $this->view()->render('sys_error', ['msg'=>$err_msg]);
    }
} 