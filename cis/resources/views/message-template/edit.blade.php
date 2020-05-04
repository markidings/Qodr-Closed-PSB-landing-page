@extends('layouts.admin')

@section('title', 'Akikahkita | Edit Template')
@section('content-title', 'Edit Template')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Template</h4>
                <div>
                    <a href="{{ route('message-templates.index') }}" class="btn btn-warning btn-sm mt-3"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Kembali</a>
                </div>
                <form class="mt-5"
                    action="{{ route('message-templates.update', [
                        'message_template' => $template->id
                    ]) }}"
                    method="POST"
                >
                @csrf
                @method('PUT')
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input
                                        name="title"
                                        type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        required
                                        placeholder="Judul template..."
                                        value="{{ old('title') ?? $template->title }}"
                                    />
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select name="type" class="form-control">
                                        <option {{ $template->type === 'broadcast' ? 'selected' : '' }} value="broadcast">Broadcast</option>
                                        <option {{ $template->type === 'report' ? 'selected' : '' }} value="report">Report Client</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pesan</label>
                                    {{-- %paket%, %pemesan%, %anak%, %ayah%, %ibu%, dan %status proses% --}}
                                    <div style="margin-bottom:.5rem;">
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%paket%')">%paket%</button>
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%pemesan%')">%pemesan%</button>
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%anak%')">%anak%</button>
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%ayah%')">%ayah%</button>
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%ibu%')">%ibu%</button>
                                        <button type="button" class="btn btn-rounded btn-sm btn-outline-info" onclick="appendMessageText('%status_proses%')">%status_proses%</button>
                                    </div>
                                    <textarea
                                        id="messageTextArea"
                                        name="message"
                                        required
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Pesan template..."
                                        rows="5"
                                    >{{ old('message') ?? $template->message }}</textarea>
                                    <div style="margin-top:.5rem;">
                                        <button class="btn btn-outline-danger btn-sm btn-rounded" type="button" onclick="clipTextWith('*')">
                                            <span class="fas fa-bold" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Bold
                                        </button>
                                        <button class="btn btn-outline-success btn-sm btn-rounded" type="button" onclick="clipTextWith('_')">
                                            <span class="fas fa-italic" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Italic
                                        </button>
                                        <button class="btn btn-outline-warning btn-sm btn-rounded" type="button" onclick="clipTextWith('~')">
                                            <span class="fas fa-strikethrough" data-fa-transform="shrink-3"></span>&nbsp;&nbsp;Strikethrough
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-5">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
    function appendMessageText(text) {
        const messageTextAreaElm = document.getElementById('messageTextArea');
        const newValue = `${messageTextAreaElm.value} ${text} `;
        messageTextAreaElm.value = newValue;
    }

    function clipTextWith(sign) {
        const messageTextAreaElm = document.getElementById('messageTextArea');
        const textValue = messageTextAreaElm.value;

        let startText = '';
        let endText = '';
        let selectedText = '';

        if (messageTextAreaElm.selectionStart != undefined) {
            const startPos = messageTextAreaElm.selectionStart;
            const endPos = messageTextAreaElm.selectionEnd;

            selectedText = messageTextAreaElm.value.substring(startPos, endPos);
            startText = messageTextAreaElm.value.substring(0, startPos);
            endText = messageTextAreaElm.value.substring(endPos, textValue.length);
        }

        messageTextAreaElm.value = startText + sign + selectedText + sign + endText;
    }
    </script>
@endpush
