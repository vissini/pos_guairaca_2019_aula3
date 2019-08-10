<?php
__________AULA 2__________
//rotas
//controller
//model
//view
//controller com resource
//model com migration
//blade
//template
//includes
//requests

//No edit ou no create, poderiamos usar o fill para atribuir apenas os valores de fillable, e depois usar o metodo save();

//Demonstrar alguns metodos que podem ser utilizados com o request
dd($request->all());

//   suponde que quisesse pegar apenas alguns campos
  $request->only(['name']);
  $request->except(['name']);
  $request->input('name');
  $request->input('name', 'valor_default');

// Mostrar que da um erro se o ativo estiver vazio.
//Para resolver:
$dataForm['ative'] = isset($dataForm['ative'])?1:0;
//uma outra forma seria:
//esse metodo retorna true or false, então nem precisamos da condição ternaria
$dataForm['ative'] = $request->has('ative');



//PAGINACAO
//explicar importancia
//Mostrar paginacao
//criar um atributo no construct para definir o numero de itens por pagina
private $totalPage = 3;

//no metodo index
//mudar o ->find() por:
paginate($this->totalPage);

//Mostrar que se atualizar a pagina vai vir apenas esse numero de itens
//Mostrar como adicionar os links da paginação
{!! $products->links() !!}

//Mostrar depois o findorfail

//findOrFail() onde se não encontrar dá um 404


//__VALIDAÇÂO DE DADOS____
//Dizer que é essencial, pois qualquer pessoa de má fé pode tentar manipular esses dados.
//Laravel nos dá uma estrutura bem robusta.
https://laravel.com/docs/5.5/validation
//Em avalible, ver todas as regras disponíveis
exemplo básico:
$this->validate($request, [
	'number' => 'required|numeric',
    'category' => 'required',
    'description' => 'min:3|max:1000',
]);
//Mostrar que tentar enviar o formulário que não respeitar as regras vai dar erro, e não vai gravar.
//Mostrar onde ficam as mensagens de validação;
//Dizer que toda mensagem de erro qdo usado o método acima, já fica na variable $erros
Como mostrar o erro:
@if( isset ($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        @foreach( $errors->all() as $error )
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if( $errors->any() )
    <div class="alert alert-danger">
        @foreach( $errors->all() as $error )
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

//Lembrar que para ajudar nessa validação de campos obrigatórios, campos date, campos e-mail, poderiamos utilizar a propria validação do HTML, mas nunca deixando de validar no servidor

//Transformar em uma function para reaproveitar nas funções
	protected function _validate(Request $request){
        $this->validate($request, [
            'name' => 'required|max:100',
            'number' => 'required|numeric',
            'category' => 'required',
            'description' => 'nullable|min:3|max:1000',
        ]);
    }

// Demonstrar que podemos passar um terceiro parametro no validate que seriam as mensagens de erro
['URL.required' => 'URL is required.']

//Podemos adicionar a parte de mostrar os erros em um arquivo especifico, que pode ser usado em qualquer tela. (VIEW)
//usar com include

//Mostrar como poderiamos definir que o campo number tem que ser unico.
//|unique:tabela,campo
'number' => 'required|numeric|unique:products,number',


//Como ficaria na edição, pois se eu abrir o formulário e clicar em editar ele vai acusar o erro, pois o valor do campo number já existe no banco
//Colocar na regra para ignorar um certo id.
//Primeiro pegar o id que veio do request
$productId = $request->route('product');
//alterar a regra para:
'number' => "required|numeric|unique:products,number, $productId",


//Mostrar como recuperar os dados que foram digitagos no formulario de criação qdo deu erro.
value="{{ old('name',$prod->name) }}"

//Agora vamos ver outro recurso muito legal, relativo ao parametros de rotas, chamado de Route Model Binding
//Isso é possível qdo o parametro tem o nome do modelo.
//Dai pode ser removido o find or fail
//Lembrar que qdo fizer isso a validação de unique vai dar erro, pois como está usando o novo formato o que vamos ter no _validate é um objeto de Client, então devemos alterar o código para:
$product = $request->route('product');
$productId = $product instanceof Product ? $product->id : null;



//Melhorar a estrutura de validação.
//Devemos considerar que a validação não deve ser obrigação do controller.
//vamos alterar utiizando o form_request
//é uma requisição personalizada, porém dentro dela temos o poder de fazer validação e tb outras tarefas.
php artisan make:request ProductRequest

//no método rules, devemos especificar as regras;
//Copiar as regras que tinhamos no controller para o formrequest
return rules = [
regras
];


//Substituir no parametro dos metodos no controller pelo formRequest criado.
//no metodo autorizhe, devemos setar como true, pois não estamos checando se a pessoa está autorizada ou não

// se quiser podemos adicionar um novo metodo para mensagens
public function messages()
{
    return [
        messages
    ]
}


//________________FLASH_MESSAGES___________________________
//como mostrar uma mensagem de sucesso por exemplo??
//poderia jogar na sessão, pois fica apenas para sessao atual, atualizou a pagina sumiu

//exemplo manual de flash session
//para setar:
\Session::flash('chave','valor');
//colocar no index
//pera usar:
{{Session::get('chave')}}
//colocar na view create
//desfazer
//Outra forma é usando with
->with('chave', 'valor');


//Lembrar que tem que alterar onde mostrar os erros, para mostrar a mensagem de sucesso tb.
//passar como chave no flash o success
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <ul class="alert alert-danger padding-lg">
        @foreach ($errors->all() as $error)
            <li class=''>{{$error}}</li>
        @endforeach
    </ul>
@endif


//MOSTRAR ERRO PARA CADA CAMPO / Components e Slots
//Dizer que as vezes seria interessante mostrar a mensagem de erro para cada campo
//Vamos usar o modelo do bootstrap para mostrar os erros
	<div class="invalid-feedback">
		{{ $errors->first('name') }}
	</div>
//first é para pegar o primeiro erro para o campo nome, pois pode haver mais erros.
//Para mostrar o erro e deixar a cor vermelha devemos adicionar a classe is-invalid no campo qdo tiver o erro
class="form-control {{ $errors->has('name')?' is-invalid':'' }} "

//Porém, pensa se vc tiver um formulário com muitos campos, ou até mesmo se seu sistema vai ter varios formuários, 
//Isso pode ser bem trabalhoso de ser feito, então podemos usar os componentes e slots do LAravel
//Comopnente é uma estrutura HTML que pode ser reaproveitado
//Criar uma pasta Components
//dentro criar um arquivo chamado
_form_group_component.blade.php
//Adicionar dentro desse arquivo o código:
<div class="form-group">
    {{ $slot }}
    <div class="invalid-feedback">
        {{ $errors->first($field) }}
    </div>
</div>
//E no arquivo _form alterar onde tinha o form group para:
@component('admin.component._form_group_component', ['field' => 'name'])
	<label for="name" class="col-form-label">Nome</label>
	<input type="text" class="form-control {{ $errors->has('name')?' is-invalid':'' }}" name='name' id="name" placeholder="Nome"  value="{{ old('name',$prod->name) }}">    
@endcomponent


//MUTATORS e Formatação de Dados
//Para setar uma formatação na hora de mostrar o campo podemos criar um mutator no modelo
public function getActiveAttribute(){
	return 'adfasdfadsf';
}
//e mostrar na listagem que já trouxe o campo Active nesse formato.
//Mostrar como ficaria para retornar sim ou não
public function getActiveAttribute(){
	return $this->active?'Sim':'Não';
}
//Dizer que ocorreu um erro esperado, pois você define o mutator para ser acessado com o mesmo nome que estamos usando abaixo. Nesse caso devemos alterar para:
public function getActiveAttribute(){
	return $this->attributes['active']?'Sim':'Não';
}
//Porém eu não gosto de criar um mutator para o nome padrão, pois se quero pegar o valor original não consigo, então crio sempre assim:
//Comentar exemplo anterior
    public function getActiveFormattedAttribute(){
        return $this->attributes['active']?'Sim':'Não';
    }
	
//Ir na view do index e alterar para pegar o valor formatado
<td>{{ $product->active_formatted }}</td>

//Mostrar como guardar no banco valor limpo
//remover a validação de mumeric no campo number
//Adicionar seguinte código no modelo
    public function setNumberAttribute($value){
        $this->attributes['number'] = preg_replace('/[^0-9]/', '', $value);
    }
	
//Testar alterar um produto, passando letras junto com o number


//TRADUÇÂO
//Resources/lang/en
baixar tradução em laravel-lang
composer require caouecs/laravel-lang:~3.0

acessar pasta vendor e ir em cauoecs e copiar a pt_br para resources lang
alterar o config app.php

//HELPER ASSET
//Usado para acessar os arquivos assets raiz
{{ asset('css/app.css') }}
{{ asset('css/app.js') }}




//--------------------------------------------------------------------------------------------------------------------------------------
//____ORM______

//Convenções________
//Pode perceber que em momento algum digitamos o nome da tabela e nem a chave primaria, mas como seria se nosso banco não se enquadrasse na convensão do Laravel
//O nome da tabela por padrão, é sempre o nome do modelo no plural. Se o modelo tiver 2 nomes: NomeSobrenome o nome da tabela no banco vai sre nome_sobrenomes
//Mas e quando o nome da nossa tabela não casar com o nome do model, como fazemos:
//No model devemos criar um atributo:
protected $table = 'NomeDaTabela';

//Outra coisa que podemos mudar é a chave primaria, o model por padrão considera que toda tabela vai ter por padrão a chave primario o campo de ID
protected $primaryKey = 'chave';
//;Pelo que pesquisei o eloquent não aceita chave primaria composta, então deve-se trabalhar de forma manual com o Laravel, ou evitar chave composta
//Por padrão a chave é sempre autoIncrement, mas se quiser mudar só setar a propriedade 
protected $incrementing = false;
//E podemos mudar o tipo da chave tb
protected $keyType = 'string';

//Se não quiser criar os timestampos devemos definir o attributo:
public $timestamps = false;

//O model fica ligado sempre ao banco do .env, mas pode ser que queira utilizar esse modelo com outra conexão, para isso:
protected $connection = 'sqlite';

//Outra coisa é relação as datas....por padrão o eloquent tras apenas as datas do timestamp usando o Carbon (Pacote php que nos ajuda a trabalhar com datas)
//Como teria que fazer para converter as outras datas da tabela
protected $dates = ['todos os campos de data, inclusive o create_at e update_at'];



//____SCOPES
//Seria quando vc já quer definir um padrão de busca...
//Usando como exemplo a tabela de produtos, onde queremos listar apenas os produtos de informatica, para não ter que fazer isso em todos os lugares, podemos usar o scopo
//Criar um metodo no modelo de produtos
public function scopeInformatica($query)
{
	return $query->where('category','informatica');
}

//para usar::
$productsIformatica = Products::Informatica()->get();

//Para deixar mais generico, poderiamos passar um outro parametro, que seria o type
public function scopeOfType($query, $type)
{
	return $query->where('category',$type);
}

//para usar::
$productsIformatica = Products::ofType('informatica')->get();

//Mas vamos supor que vc tivesse uma condição na sua tabela que fosse global para todas as consultas. Então mesmo com o scope não seria muito pratico.
//Para resolver isso temos o scopo global
//Pensando que nossa tabela tivesse um campo que seria a data de publicação do produto. E quisessemos buscar sempre os produtos já publicados
//Primeiro vamos alterar nossa migration
php artisan make:migration add_publish_at_table_products --table=products
//No metodo Up
$table->date('publish_at')->nullable()->after('description');

//No metodo down
$table->dropColumn('publish_at');

//Rodar comando 
php artisan migrate

//Para adiantar vamos adicionar data em alguns registros do banco de forma manual
//Agora adicionar no modelo o seguinte metodo:
use Illuminate\Database\Eloquent\Builder;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('published', function (Builder $builder){
            $builder->where('publish_at', '!=', "");
        });
    }

//Abrir o tinker e mostrar que o all() só tras os resultados com data no publish_at
App\Models\Admin\Product::all()

//Mas e se por acaso eu quiser fazer uma busca sem esse scopo global??
App\Models\Admin\Product::withoutGlobalScope('published')->get();


//Além disso temos o softdelete, que seria como se fosse um scopo global padrão do laravel.
//Como funciona:
//Primeiro alterar tabela
php artisan make:migration add_soft_deletes_to_products_table --table="products"

//No up
$table->softDeletes();
//no down
$table->dropSoftDeletes();

php artisan migrate

//Dentro do model products chamar o softDeletes
use Illuminate\Database\Eloquent\SoftDeletes;

//e dentro da classe onde vai o products
use SoftDeletes;

protected $dates = ['deleted_at'];

//Agora vamos testar
App\Models\Admin\Product::all();
//Escolher um ID
$product = App\Models\Admin\Product::find(id);
$product->delete()
App\Models\Admin\Product::all();
//Ver que o registro foi apagado
//Olhar como ficou o banco de dados

//Como faria para buscar todos os registros, inclusive os excluidos
App\Models\Admin\Product::withTrashed()->get();

//Para ver somente os excluidos
App\Models\Admin\Product::onlyTrashed()->get();

//Se quiser ver se o registro está excluido ou não
App\Models\Admin\Product::trashed();
//Vai retornar true or false;
//E se quiser buscar um resgrito pelo id independente de estar ou não excluido
App\Models\Admin\Product::withTrashed()->find(4);

//Para restaurar o registro, instanciar ele com o comando acima
$post->restore();

//Criar um novo projeto - aula 3
//Criar um novo banco - aula 3
//Utilizar a collection padrão.
//Como resolver o erro do unique?? Lembrando, ou podemo limiter o campo por exemplo a 100 caracteres ou :
//Alterar o arquivo App/providers/AppServiceProvider
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
	
//Alterar configurações gerais

//Criando Tabelas one to one
//Vamos criar tabelas Paises e tabela location, onde vamos fazer o relacionamento 1 X 1
//Criar model com a migration
php artisan make:model Models\Country -m
//Por eqto não vamos mudar nada na nossa model
//Adicionar campos na tabela contries
		Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150)->unique();
            $table->timestamps();
        });
//Criar uma model para location tb
php artisan make:model Models\Location -m
//Adicionar os campos no modelo
Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('latitude');
            $table->integer('longitude');
            $table->timestamps();
        });
		
//Explicar o porque de o nome do campo de relacionamento deve seguir esse padrão.
//Explicar que unsigned é para qe o campo aceite apenas numeros positivos
//Explicar o porque do onDelete('cascade');
//Rodar o comando abaixo para criar as tabelas
php artisan migrate

//Vamos inserir os dados manuais apenas para facilitar os nossos testes
//Lembrando que poderiamos fazer via seed, ou formulário, mas vamos fazer assim só para adiantar
//Agora vamos ver como pegamos um pais pelo seu ID e mostramos sua latitude, depois vamos ver o inverso
//Primeiro vamos criar uma rota para nosso teste
Route::get('one-to-one', 'OneToOneController@oneToOne');
//Criar o controller que vamos utilizar para os testes
php artisan make:controller OneToOneController
//Criar o método dentor do controller
	public function oneToOne()
    {
        $country = Country::find(1);
        echo $country->name;
    }
	
//Adicinar Uses para os modelos
use App\Models\Country;
use App\Models\Location;

//Mostrar que está retornando o nome do pais
//Agora vamos exibir a Location
//Na model criar um metodo:
//Uma nomeclatura padrão é:
//Como o método vai retornar apenas um registro, deixar ele no singular, se fosse retornar varios registros, seria no plural.
public function location()
{
	return $this->hasOne(Location::class);
}

//Como a model de Location está no mesmo diretório da model que estamos alterando, não é necessário dar o Use, mas poderia
//Como recupero os dados da location??
//Podemos chamar em formato de metodo ou atributo.
public function oneToOne()
    {
        $country = Country::find(1);
        echo $country->name."<br>";
        
        $location = $country->location;
        echo "Latitude {$location->latitude} - Longitude {$location->longitude}";
    }

//Podemos também encontrar o pais pelo nome, como já havia sido mostrado anteriormente:
public function oneToOne()
    {
        $country = Country::where('name', 'Brasil')->get()->first();
        echo $country->name."<br>";
        
        $location = $country->location;
        echo "Latitude {$location->latitude} - Longitude {$location->longitude}";
    }
//Se não colocassemos o first() que retorna a primeira ocorrencia, nossa forma de mostrar daria erro, pois o retorno $country, seria um array
//Se for em formato de método precisa ter o get() no final ($country->location()->get()->first();).
//O legal de usar com método é poder usar um outro relacionamento junto, ou até mesmo mais um filtro por where por exemplo.

//Agora vamos ver como seria para recuperar o pais pela location
//vamos criar a rota:
Route::get('one-to-one-inverse', 'OneToOneController@oneToOneInverse');
//Criar o metodo no controller
public function oneToOneInverse()
    {
        $latitude = 123;
        $longitude = 321;

        $location = Location::where('latitude', $latitude)->where('longitude', $longitude)->get()->first();
        echo $location->id;
    }
//Criar metodo que retorna essa ligação;
//Lembrando que como vai retornar apenas um pais o metodo é no singular
public function country()
    {
        return $this->belongsTo(Country::class);
    }
	
//Alterar contriller para listar o nome do pais.
//Mostrar um teste com a outra longitude;

//Agora vou mostrar como que seria se o nome do nossos campos não seguissem o padrão definido pelo laravel
//Se sua coluna de relacionamento tivesse um nome diferente, seria preciso apenas passar um segundo parametro no hasOne, com o nome do campo
return $this->hasOne(Location::class, 'country_id');
//Mostrar que continua funcionando
//Mostrar como seria se o ID da tabela country fosse outro nome:
//Seria o terceiro parametro
return $this->hasOne(Location::class, 'country_id', 'id');
//no Location
return $this->belongsTo(Location::class, 'country_id', 'id');
//Inserir com OneToOne
//Criar a rota e adicionar o metodo no controller
Route::get('one-to-one-insert', 'OneToOneController@oneToOneInsert');
public function oneToOneInsert()
    {
        $dataForm = [
            'name' => 'Alemanha',
            'latitude' => '789',
            'longitude' => '987',
        ];

        $country = Country::create($dataForm);
    }
//Lembrando que esse create vai dar erro ainda, pois não definimos os fillable no modelo
//Adicionar nos dois modelos
//Lembrar que o $country recebe os dados do objeto que foi inserido
public function oneToOneInsert()
    {
        $dataForm = [
            'name' => 'Alemanha',
            'latitude' => '789',
            'longitude' => '987',
        ];

        $country = Country::create($dataForm);

        $dataForm['country_id'] = $country->id;
        $location = Location::create($dataForm);
    }
	
	//Poderia também inserir criando um objeto location, atribuir campo a campo + Country_id e usar o save.
	//Outra forma mais simples ainda, seria:
	$location = $country->location()->create($dataForm);
	
	//Inclusive nesse ultimo formato podiamos usar para adicionar a location em um pais que ainda não existe location, apenas sendo necessário buscar esse pais
	
	
//___________ONE_TO_MANY______________
//Criar rota
//Criar controller
Route::get('one-to-many', 'OneToManyController@oneToMany');
php artisan make:controller OneToManyController

public function oneToMany()
{
	
}

//Para fazer esses testes vamos precisar de outra tabela
//Vamos criar uma tabela de states criando uma model
//Já vamos aproveitar e criar a parte de cidades
php artisan make:model Models\State -m
php artisan make:model Models\City -m

        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('initials', 2);
            $table->timestamps();
        });
		
		Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->string('name', 100);
            $table->timestamps();
        });
		
		

//Popular alguns dados de forma manual
//Listar todos os estados do pais Brasil
//Dar use nas models Pais e estados
//Dentro do metodo oneToMany adicionar o código abaixo para recuperar o pais
$country = Country::where('name', 'Brasil')->get()->first();
//Agora no modelo adicionar o metodo para retornar os estados
public function states()
    {
        return $this->hasMany(State::class);
    }
//Lembrando que o nome é no plural, pq vai retornar varios estados
//E que não é necessário fazer o use pois está na mesma pasta
//Voltar no modelo para fazer o código que retorna os estados	
public function oneToMany()
    {
        $country = Country::where('name', 'Brasil')->get()->first();

        $states = $country->states;

        foreach ($states as $state){
            echo "<hr> {$state->initials} - {$state->name}";
        }

    }
	
//Poderia aplicar um Filtro nos estados como por exemplo, estados que contenham a letra S na sigle
public function oneToMany()
    {
        $country = Country::where('name', 'Brasil')->get()->first();

        $states = $country->states()->where('initials', 'like', '%S%')->get();

        foreach ($states as $state){
            echo "<hr> {$state->initials} - {$state->name}";
        }

    }	


//Supondo que minha busca por paises, retornasse mais de 1 pais
public function oneToMany()
    {
     
        $keysearch = 'a';
        $countries = Country::where('name', 'like', "%{$keysearch}%")->get();

        foreach ($countries as $country){
            echo "<hr> {$country->name}";
            $states = $country->states;

            foreach ($states as $state){
                echo "<br> {$state->initials} - {$state->name}";
            }
        }

        

    }

//Agora vamos fazer o one_to_many_inverse
Route::get('many-to-one', 'OneToManyController@manyToOne');
public function manyToOne()
    {
        $stateName = 'Paraná';
        $state = State::where('name', $stateName)->get()->first();

        echo "<b>{$state->name}</b><br>";
    }
	
//Mostrar que retornou o estado
//Criar método no modelo State
public function country()
    {
        return $this->belongsTo (Country::class);
    }
	
//Agora alterar o metodo para retorna o pais desse estado
public function manyToOne()
    {
        $stateName = 'Paraná';
        $state = State::where('name', $stateName)->get()->first();

        echo "<b>{$state->name}</b><br>";

        $country = $state->country;
        echo $country->name;
    }
	
//Dicas Preciosas
//Imagina que vc tem muitos estados, para cada exemplo anterior, para cada estado ele faz uma consulta que tras os estados, o que pode gerar um certo delay.	
//No método one-to-many adicionar um dd($country); para entender o retorno
dd($country);
//Em original, tem todas as informações do pais, sem nenhuma informação a mais.
//Alteerar para trazer as informações de cada país.
public function oneToMany()
    {
        //$country = Country::where('name', 'Brasil')->get()->first();

        $keysearch = 'a';
        $countries = Country::where('name', 'like', "%{$keysearch}%")->with('states')->get();

        dd($countries);

        foreach ($countries as $country){
            echo "<hr> {$country->name}";
            $states = $country->states;

            foreach ($states as $state){
                echo "<br> {$state->initials} - {$state->name}";
            }
        }
    }
//Verificar que agora tem mais uma informação com resultado o relations
//e para mostrar os resultados
	public function oneToMany()
    {
        //$country = Country::where('name', 'Brasil')->get()->first();

        $keysearch = 'a';
        $countries = Country::where('name', 'like', "%{$keysearch}%")->with('states')->get();

        foreach ($countries as $country){
            echo "<hr> {$country->name}";
            $states = $country->states;

            foreach ($states as $state){
                echo "<br> {$state->initials} - {$state->name}";
            }
        }
    }
//?????PROCURAR COMO FILTRAR OS DADOS DO WITH

//Agora vamos ver como exibir as cidades do estado
//Criar a rota e metodo no controller
// criar o metodo no modelo
    public function cities()
    {
        return $this->hasMany(City::class);
    }


//Agora vamos aprender a como cadastrar um pais já com um estado
Route::get('one-to-many-insert', 'OneToManyController@oneToManyInsert');
public function oneToManyInsert()
    {
        
    }
//Vamos recuperar um pais
    public function oneToManyInsert()
    {
        $dataForm = [
            'name' => 'Ceará',
            'initials' => 'CE'
        ];

        $country = Country::find(1);

        $insertState = $country->states()->create($dataForm);
        dd($insertState);

    }
	
//Tentar rodar, e verificar pq deu o erro??
//Faltou setar o $fillable	
//Agora deu certo

//Agora vou mostrar outra forma de fazer o insert
public function oneToManyInsertTwo()
    {
        $dataForm = [
            'name' => 'Rio Grande do Sul',
            'initials' => 'RS',
            'country_id' => '1',
        ];

        $insertState = State::create($dataForm);
        dd($insertState);

    }
	
//Vai dar o erro, pq não tem o country_id no fillable	
//Adicionar e mostrar que deu certo

//Agora vamos ver o hasManyThrough
//Que seria como se eu quisesse acessar as cidades diretamente do pais, sem passar pelos estados
Route::get('has-many-through', 'OneToManyController@hasManyThrough');
public function hasManyThrough()
{
	
}

//Criar o metodo cities no modelo country
public function cities()
{
	return $this->hasManyThrough(City::class, State::class);
}

//Crar método no contoller
public function hasManyThrough()
    {
        $country = Country::find(1);
        echo "<b>{$country->name}</b><br>";
        $cities = $country->cities;
        foreach ($cities as $city)  {
            echo " {$city->name}, ";
        }
        echo "<hr>";
    }

//retornar o total de cidades
$cities->count();

//Agora vamos falar do many to Many. Para isso vamos adicionar a table company, onde posso ter uma empresa em várias cidades, 
//e várias empresas em uma mesma cidade, sendo um relacionamento de N par NO.
//Nesse casso para poder vincular esses dados precisamos criar uma tabela pivo.
php artisan make:model Models\Company -m
//Também devemos criar uma migration que é a tabela pivo. Para criar ela rodamos o comando abaixo:
php artisan make:migration create_city_company_table
//Lembrando que o padrão que o Laravel trabalha para esse tipo de migration é colocar a ordem das tabelas, sempre em ordem alfabetica.
  Schema::create('companies', function (Blueprint $table) {
		$table->increments('id');
		$table->string('name', 200);
		$table->timestamps();
	});
Schema::create('city_company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });
//Rodar o comando:
php artisan migrate
//Inserir os dados manualmente
//Criar rota
Route::get('many-to-many', 'ManyToManyController@ManyToMany');
//Criar controller
php artisan make:controller ManyToMany
//criar metodo no controller
public function manyToMany()
{
}

//Criar método no modelo city
public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
//aqui se não tivessemos seguidp padrão do nome da tabela pivo em ordem alfabetica, deveriamos passar um segundo parametro, que seria o nome da tabela.

//alterar function do controller para listas os dados
    public function manyToMany()
    {
        $city = City::find(2);
        echo $city->name."<br>";
        $companies = $city->companies;
        foreach ($companies as $company ) {
            echo " {$company->name}, ";
        }
    }
	
//Agora vamos ver ao contrario, em qual cidade tem aquela empresa	
Route::get('many-to-many-inverse', 'ManyToManyController@ManyToManyInverse');

//Criar metodo cities no modelo company
public function Cities()
    {
        return $this->belongsToMany(City::class);
    }
	
//Dar use no company no controllre
use App\Models\Company;

public function manyToManyInverse()
    {
        $company = Company::find(2);
        echo $company->name."<br>";
        $cities = $company->cities;
        foreach ($cities as $city ) {
            echo " {$city->name}, ";
        }
    }
	
//Adicionar novas cidades para essa empresa e testar


//Insert Many to Many
//Criar rota
Route::get('many-to-many-insert', 'ManyToManyController@ManyToManyInsert');

//Criar metodo no controle
public function manyToManyInsert()
    {
        $dataForm = [2,3,4];
        
        $company = Company::find(1);
        echo $company->name."<br>";
        $company->cities()->attach($dataForm);
        $cities = $company->cities;
        foreach ($cities as $city ) {
            echo " {$city->name}, ";
        }
    }
//Outro possibilidade ao inves do attach é o sync vai deixar apenas os que vc passou. Mas por exemplo se vc tinha duplicado uma cidade ele vai mandar...
//O que ele faz para cada item é:
//Se não existir ocorrencia, adicionar
//Se existir pelo menos uma não faz nada
//E todos os outros itens que existiam no banco, mas não foram passados, ele apaga
public function manyToManyInsert()
    {
        $dataForm = [2,3,4];
        
        $company = Company::find(1);
        echo $company->name."<br>";
        $company->cities()->sync($dataForm);
        $cities = $company->cities;
        foreach ($cities as $city ) {
            echo " {$city->name}, ";
        }
    }
//Tenho o metodo detach tb. 
//Se não passar nenhum parametro, ele apaga todos os inseridos, senão vai apagar os que vc passar
//Ele retorna a quantidade de itens que removeu



//RELACIONAMENTO POLIMORFICO
//O que seria esse relacionamento.
//Vamos supor que quisessemos adicionar comentarios para cada cidade, para cada estado e para cada pais.
//Qual seria nossa primeira ideia, criar uma tabela para comentarios de cidade e fazer um relacionamento 1XN mesmo para estado e pais.
//Porém o Laravel tem um recurso que é o relacionamento polimorfico, que nos permite criar apenas uma tabela para isso. Vamos ver como funcionando
//Vamos criar uma nova rota
Route::get('polymorphic', 'PolymorphicController@polymorphic');
//Criar um novo controller
php artisan make:controller PolymorphicController
//Criar o metodo no controller
public function polymorphic()
    {
        
    }
//Agora vamos criar a model com migration
php artisan make:model Models\Comment -m
//Alterar migration criada e rodar ela
Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->morphs('owner');
            $table->timestamps();
        });
php artisan migrate
//Mostrar como ele criou os campos

//No controller dar um use na model de city, state, country e comment
//Criar um metodo no modelo
public function owner()
    {
        return $this->morphTo();
    }

//Vamos trabalhar primeiro com a inserção, então vamos criar uma nova rota e um novo metodo	
Route::get('polymorphic-insert', 'PolymorphicController@polymorphicInsert');
public function polymorphicInsert()
    {
        
    }
	
//Agora vamos na model de city para criar o metodo que vai retornar os comentários da cidade
public function comments()
{
	return $this->morphMany(Comment::class, 'owner');
}

//Agora vamos criar o código para inserir um comentário para uma cidade especifica
public function polymorphicInsert()
    {
        $city = City::find(1);

        $comment = $city->comments()->create([
            'description' => "Comentário para cidade {$city->name} em ".date('d-m-y h:i:s')
        ]);

        dd($comment->description);
    }
	
//Adicionar no modelo comment o fillable para description
//Verificar que adicionou no banco, e mostrar como ele adicionou

//Mas e se eu quisesse adicionar um comentário para o país ou para o estado....
//Primeiramente apenas criar o mesmo metodo nos modelos
$city = City::find(1);
        $comment = $city->comments()->create([
            'description' => "Comentário para cidade {$city->name} em ".date('d-m-y h:i:s')
        ]);

        $country = Country::find(1);
        $comment = $country->comments()->create([
            'description' => "Comentário para País {$country->name} em ".date('d-m-y h:i:s')
        ]);

        $state = State::find(1);
        $comment = $state->comments()->create([
            'description' => "Comentário para Estado {$state->name} em ".date('d-m-y h:i:s')
        ]);

//Agora vamos ver como listar esses comentários
public function polymorphic()
    {
        $city = City::find(1);
        echo "<hr> Cidade: {$city->name} <br>";

        $comments = $city->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }

        $state = State::find(1);
        echo "<hr> Estado: {$state->name} <br>";

        $comments = $state->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }

        $country = Country::find(1);
        echo "<hr> Cidade: {$country->name} <br>";

        $comments = $country->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }
    }	




//Qdo falar sobre o faker, verificar a aula de validação de formulários
//Mostrar que pode ser escolhido qual linguagem trabalhr com o faker...ver aula em avançado com formulários avançados

//Comentar que na migration se vc alterar o nome de algum arquivo ou excluir algum arquivo, para que o comando migrate funcione, deve ser necessario rodar o compoando:
composer dump-autoload


Se sobrar tempo mostrar a parte de autenticar admin usando o adminlte

//___AUTOCOMPLETE - Ver aula em Avançado com Formulários e Validações
https://github.com/barryvdh/laravel-ide-helper
//rodar o comando do composer:
composer require --dev barryvdh/laravel-ide-helper
//Adicionar em app/Providers/AppServiceProvider.php
public function register()
{
    if ($this->app->environment() !== 'production') {
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }
    // ...
}

//PHPDOC NO EDITOR
//rodar comando paga gerar o PHPDoc de forma automatica
php artisan ide-helper:generate
//Vai gerar o arquivo _ide_helper na raiz do projeto com todas as facades.
//Adicionando o help com uma documentação
//Devemos ignorar esse arquivo no git
//autocomplete para model
php artisan ide-helper:models
Digitar no para gerar arquivo separado.
//Vai dar um erro que precisa adicionar um arquivo
//Adicionar com 
composer require doctrine/dbal:~2.3
rodar o comando novamente.



https://github.com/jeroennoten/Laravel-AdminLTE
