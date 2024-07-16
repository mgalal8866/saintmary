<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAccountRequest;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $accounts = Account::with('service'); // Initialize the query with the relationship loaded

        if ($request->has('service_id')) {
            $accounts->where('service_id', $request->service_id); // Apply the filter if 'service_id' is present
        }
        if ($request->has('fromdata') &&$request->has('todata') ) {
            $accounts->whereBetween('created_at', [$request->fromdata, $request->todata]); // Apply the filter if 'service_id' is present
        }

        $accounts = $accounts->get(); // Retrieve the accounts
        $services = Service::get();
        return view('admin.accounts.index', compact('accounts', 'services'));
    }

    public function create()
    {
        abort_if(Gate::denies('account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.accounts.create', compact('services'));
    }

    public function store(StoreAccountRequest $request)
    {
        $account = Account::create($request->all());

        return redirect()->route('admin.accounts.index');
    }

    public function edit(Account $account)
    {
        abort_if(Gate::denies('account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $account->load('service');

        return view('admin.accounts.edit', compact('account', 'services'));
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->all());

        return redirect()->route('admin.accounts.index');
    }

    public function show(Account $account)
    {
        abort_if(Gate::denies('account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $account->load('service');

        return view('admin.accounts.show', compact('account'));
    }

    public function destroy(Account $account)
    {
        abort_if(Gate::denies('account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $account->delete();

        return back();
    }

    public function massDestroy(MassDestroyAccountRequest $request)
    {
        $accounts = Account::find(request('ids'));

        foreach ($accounts as $account) {
            $account->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
