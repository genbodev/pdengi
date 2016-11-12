<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class BalanceController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(User $userModel) {
    $users = $userModel->getAllUsersLastComment();
    return view('balance.index', ['users' => $users]);
  }

  public function moneyOrder(Request $request, User $userModel) {

    if ($request->ajax()) {
      $dataTransaction = $request->all();
      $sender = $dataTransaction['senderID'];
      $recipient = $dataTransaction['recipientID'];
      $sender_sum = $dataTransaction['senderSum'];
      $recipient_sum = $dataTransaction['recipientSum'];
      $add_sum = round($dataTransaction['addSum'], 2);
      return $userModel->sendMoney($sender, $recipient, $sender_sum, $recipient_sum, $add_sum);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int $id
   * @return Response
   */
  public function update($id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return Response
   */
  public function destroy($id) {
    //
  }

}
