<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\MessageTemplate\StoreMessageTemplate;

use App\Models\MessageTemplate;
use App\Models\Role;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        // authorize role
        // $partnerRole = Role::PARTNER;
        // $this->middleware("role:{$partnerRole}");
    }

    public function index()
    {
        $partnerID = auth()->user()->id;
        $messageTemplates = MessageTemplate::where('partner_id', $partnerID)->get();

        return view('message-template.index', compact('messageTemplates'));
    }

    public function create()
    {
        return view('message-template.create');
    }

    public function store(StoreMessageTemplate $request)
    {
        $newTemplate = $request->validated();
        $newTemplate['partner_id'] = auth()->user()->id;

        MessageTemplate::create($newTemplate);

        flash('Data berhasil ditambahkan.', 'success');

        return redirect()->route('message-templates.index');
    }

    public function edit(MessageTemplate $message_template)
    {
        $template = $message_template;
        return view('message-template.edit', compact('template'));
    }

    public function update(StoreMessageTemplate $request, MessageTemplate $message_template)
    {
        $updatedTemplate = $request->validated();

        $message_template->update($updatedTemplate); 

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('message-templates.index');
    }

    public function destroy(MessageTemplate $message_template)
    {
        $message_template->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
