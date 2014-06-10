<?php

class ClientController extends BaseController {
	protected $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public function index() {
		return View::make('client.index', [
			'allClients' => Client::orderBy('created_at', 'desc')->take(125)->get(),
		]);
	}

	public function show($clientID) {
		$client = $this->client->find($clientID);

		return View::make('client.show', [
			'client' => $client,
			'trails' => $client->organizedTrails(),
		]);
	}

	public function store() {
		$data = ['name' => Input::get('client_name')];
		$v = Validator::make($data, Client::$rules);

		if ($v->fails())
			return Redirect::back()->withErrors($v)->withInput();

		else {
			Client::create(['name' => Input::get('client_name')]);
			return Redirect::back();
		}
	}

	public function destroy($id) {
		Client::destroy($id);
		return Redirect::to('/');
	}
}
