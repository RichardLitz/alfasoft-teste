@extends('layouts.app')

@section('title', 'Lista de Contatos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Lista de Contatos</h4>
            @auth
                <a href="{{ route('contacts.create') }}" class="btn btn-primary">Novo Contato</a>
            @endauth
        </div>
        <div class="card-body">
            @if($contacts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-sm btn-info">
                                            Detalhes
                                        </a>
                                        
                                        @auth
                                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-warning">
                                                Editar
                                            </a>
                                            
                                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" 
                                                  class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este contato?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                            </form>
                                        @endauth
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="alert alert-info mb-0">
                    Nenhum contato encontrado. 
                    @auth
                        <a href="{{ route('contacts.create') }}">Clique aqui</a> para adicionar.
                    @else
                        Faça <a href="{{ route('login') }}">login</a> para adicionar contatos.
                    @endauth
                </div>
            @endif
        </div>
    </div>
@endsection