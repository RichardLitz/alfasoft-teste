@extends('layouts.app')

@section('title', 'Detalhes do Contato')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detalhes do Contato</h4>
            <div>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informações Pessoais</h5>
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-3">ID:</dt>
                        <dd class="col-sm-9">{{ $contact->id }}</dd>
                        
                        <dt class="col-sm-3">Nome:</dt>
                        <dd class="col-sm-9">{{ $contact->name }}</dd>
                        
                        <dt class="col-sm-3">Telefone:</dt>
                        <dd class="col-sm-9">{{ $contact->phone }}</dd>
                        
                        <dt class="col-sm-3">E-mail:</dt>
                        <dd class="col-sm-9">{{ $contact->email }}</dd>
                        
                        <dt class="col-sm-3">Criado em:</dt>
                        <dd class="col-sm-9">{{ $contact->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-3">Atualizado em:</dt>
                        <dd class="col-sm-9">{{ $contact->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
            </div>

            @auth
                <div class="d-flex gap-2">
                    <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">Editar</a>
                    
                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este contato?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
@endsection