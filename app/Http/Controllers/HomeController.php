<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
$memos = Memo::where('user_id', $user['id'])->where('status', 1)->orderby('updated_at', 'DESC')->get();
        return view('home', compact('user', 'memos'));
    }

    public function create()
    {
        $user = \Auth::user();
        return view('create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // POST���ꂽ�f�[�^��DB�imemos�e�[�u���j�ɑ}��
        // MEMO���f����DB�֕ۑ����閽�߂��o��

        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
             'user_id' => $data['user_id'],
            //  'tag_id' => $tag_id,
             'status' => 1
        ]);

        // ���_�C���N�g����
        return redirect()->route('home');
    }

    public function edit($id){
        $user = \Auth::user();
        $memo = Memo::where('status', 1)->where('id', $id)->where('user_id', $user['id'])
          ->first();
        $memos = Memo::where('user_id', $user['id'])->where('status', 1)->orderby('updated_at', 'DESC')->get();

          return view('edit', compact('memo', 'user', 'memos'));
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        // dd($inputs);
        Memo::where('id', $id)->update(['content' => $inputs['content']]);
        return redirect()->route('home');
    }

}
