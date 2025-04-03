<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    
    private $user;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Cria um usuário para autenticação
        $this->user = User::factory()->create();
    }
    
    /** @test */
    public function user_can_view_contacts_list()
    {
        Contact::create([
            'name' => 'Usuário Teste',
            'phone' => '123456789',
            'email' => 'teste@example.com',
        ]);
        
        $response = $this->get(route('contacts.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Usuário Teste');
        $response->assertSee('123456789');
        $response->assertSee('teste@example.com');
    }
    
    /** @test */
    public function guest_cannot_create_contacts()
    {
        $response = $this->post(route('contacts.store'), [
            'name' => 'Novo Contato',
            'phone' => '987654321',
            'email' => 'novo@example.com',
        ]);
        
        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('contacts', ['name' => 'Novo Contato']);
    }
    
    /** @test */
    public function authenticated_user_can_create_contacts()
    {
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Nome Completo',
                'phone' => '987654321',
                'email' => 'email@example.com',
            ]);
        
        $response->assertRedirect(route('contacts.index'));
        $this->assertDatabaseHas('contacts', [
            'name' => 'Nome Completo',
            'phone' => '987654321',
            'email' => 'email@example.com',
        ]);
    }
    
    /** @test */
    public function name_is_required_and_min_length()
    {
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Test', // Menos que 5 caracteres
                'phone' => '123456789',
                'email' => 'teste@example.com',
            ]);
        
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('contacts', ['phone' => '123456789']);
    }
    
    /** @test */
    public function phone_must_be_9_digits()
    {
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Nome Completo',
                'phone' => '12345', // Menos que 9 dígitos
                'email' => 'teste@example.com',
            ]);
        
        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseMissing('contacts', ['name' => 'Nome Completo']);
    }
    
    /** @test */
    public function email_must_be_valid()
    {
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Nome Completo',
                'phone' => '123456789',
                'email' => 'email-invalido', // Email inválido
            ]);
        
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('contacts', ['name' => 'Nome Completo']);
    }
    
    /** @test */
    public function phone_and_email_must_be_unique()
    {
        // Cria um contato inicial
        Contact::create([
            'name' => 'Contato Existente',
            'phone' => '123456789',
            'email' => 'existente@example.com',
        ]);
        
        // Tenta criar outro contato com o mesmo telefone
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Novo Contato',
                'phone' => '123456789', // Telefone duplicado
                'email' => 'novo@example.com',
            ]);
        
        $response->assertSessionHasErrors('phone');
        
        // Tenta criar outro contato com o mesmo email
        $response = $this->actingAs($this->user)
            ->post(route('contacts.store'), [
                'name' => 'Novo Contato',
                'phone' => '987654321',
                'email' => 'existente@example.com', // Email duplicado
            ]);
        
        $response->assertSessionHasErrors('email');
    }
}