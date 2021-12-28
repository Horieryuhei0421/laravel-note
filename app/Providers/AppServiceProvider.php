<?php

namespace App\Providers;
use App\Memo;
use App\Tag;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            // get the current user
            $user = \Auth::user();
             // �C���X�^���X��
            $memoModel = new Memo();
            $memos = $memoModel->myMemo( \Auth::id() );

            // �^�O�Ɏ擾
             $tagModel = new Tag();
             $tags = $tagModel->where('user_id', \Auth::id())->get();

            $view->with('user', $user)->with('memos', $memos)->with('tags', $tags);
        });
    }
}
