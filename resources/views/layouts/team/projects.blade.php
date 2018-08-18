@extends('app')

@section('title', 'Team projects')

@section('content')

<main class="viewport tat-c tat-center tat-middle">
	
	<h1 class="container-l">clients & projects</h1>
	
	<div class="container-l white tat-g">
			
		<div id="projects-tree" class="tat-u-1 tat-u-lg-1-2 padding-1">
			
			@if (session('success'))
			    <div class="alert success">
			        {{ session('success') }}
			    </div>
			@endif
			
			All clients and projects.
						
			@if (count($clients) > 0)
						
				@foreach ($clients as $client)
					<div class="client-row tat-c tat-r-sm tat-hspace tat-bottom tat-top-sm pushup-1 @if (!$client->active) dormant @endif">
						<div class="client tat-u-1 tat-u-sm-2-5 tat-r tat-middle">
							<a href="#" class="tat-f-1-0">{{ $client->name }}</a>
							<a href="{{ route('admin:client:edit', $client->id) }}" class="tat-f-0-0"><i class="material-icons">edit</i></a>
						</div>
						
						@if (count($client->projects) > 0)
							<div class="client-projects tat-u-4-5 tat-u-sm-2-5 tat-c">
								@foreach ($client->projects as $project)	
									<div class="project tat-u-1 tat-r tat-middle green @if (!$project->active) dormant @endif @if (ColorsHelper::isDark($project->color)) darkcolor @endif"
										@if (!empty($project->color))
										style="background-color:#{{$project->color}};"
										@endif
										>
										<a href="{{ route('admin:projects:stats', $project->id)}}" class="tat-f-1-0">{{ $project->name }}</a>
										<a href="{{ route('admin:project:edit', $project->id) }}" class="tat-f-0-0"><i class="material-icons text-white">edit</i></a>
									</div>
								@endforeach
							</div>
						@endif
					</div>
				@endforeach
				
			@endif
			
		</div>
		
		<div id="add-client" class="tat-u-1 tat-u-sm-1-2 tat-u-lg-1-4 padding-1 lightgray">
			
			@if (isset($form) && $form=='client' && $errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			
			Add new client.
			
			<form id="client-add-form" class="top-1-2 form-white" method="POST" action="{{ route('admin:clients:create') }}">
		        {{ csrf_field() }}
		
		        <label for="name">Name</label>
		        <input id="name" type="text" class="{{ $errors->has('name') ? ' has-error' : '' }}" name="name" placeholder="Client Name" value="{{ old('name') }}" required autofocus>
		
		        @if ($errors->has('name'))
		            <div class="alert-small error">
		                {{ $errors->first('name') }}
		            </div>
		        @endif
				
				<label class="checkbox" for="active">
		            <input type="checkbox" name="active" id="active" value="1" {{ old('active') ? 'checked' : '' }}> Currently active
		        </label>
		        
		        <div>
		            <button type="submit" class="button green">
		                Add Client
		            </button>
		        </div>
		    </form>
		
		</div>
		
		<div id="add-project" class="tat-u-1 tat-u-sm-1-2 tat-u-lg-1-4 padding-1 lightgray">
			
			@if (isset($form) && $form=='project' && $errors->any())
				<div class="alert error">Моля, попълнете коректно всички полета.</div>
				@foreach ($errors->all() as $error) 
					{{ $error }}
				@endforeach
			@endif
			
			Add new project.
			
			<form id="project-add-form" class="top-1-2 form-white" method="POST" action="{{ route('admin:projects:create') }}">
		        {{ csrf_field() }}
		
		        <label for="name">Name</label>
		        <input id="name" type="text" class="{{ $errors->has('name') ? ' has-error' : '' }}" name="name" placeholder="Project Name" value="{{ old('name') }}" maxlength="30" required autofocus>
		
		        @if ($errors->has('name'))
		            <div class="alert-small error">
		                {{ $errors->first('name') }}
		            </div>
		        @endif
				
				<label for="client_search">Client</label>
		        <input id="client_search" type="text" name="client_search" placeholder="Find client by name" value="{{ old('client_search') }}" maxlength="30" required>
		        
				
				<label for="client_name-auto">Client Name</label>
				<input type="text" class="{{ $errors->has('client_id') ? ' has-error' : '' }}" name="client_name" id="client_name-auto" maxlength="30" value="{{ old('client_name') }}" readonly>
				<input type="hidden" name="client_id" id="client_id-auto" value="{{ old('client_id') }}">
				
	            @if ($errors->has('client_id'))
	                <div class="alert-small error">
		                {{ $errors->first('client_id') }}
		            </div>
	            @endif

	            <label for="budgeted">Budgeted days</label>
	            <input id="budgeted" type="number" class="{{ $errors->has('budgeted') ? ' has-error' : '' }}" name="budgeted" placeholder="Budget" value="{{ old('budget') }}"  >
	            @if ($errors->has('budgeted'))
	                <div class="alert-small error">
		                {{ $errors->first('budget') }}
		            </div>
	            @endif

	            <label for="deadline">Deadline</label>
	            <input name="deadline" placeholder="Deadline" class="{{ $errors->has('deadline') ? ' has-error' : '' }}" type="text" id="datepickerstart" value="{{ old('deadline') }}" required>
	            @if ($errors->has('deadline'))
	                <div class="alert-small error">
		                {{ $errors->first('deadline') }}
		            </div>
	            @endif
			    
			    <label for="color">Color</label>
		        <input id="color" type="text" name="color" placeholder="Project color" value="{{ old('color') }}" maxlength="6">
		        
		        {{ ColorsHelper::display() }}
		        
				<label class="checkbox push-top-1" for="active_project">
		            <input type="checkbox" name="active" id="active_project" value="1" {{ old('active') ? 'checked' : '' }}> Currently active
		        </label>
		        
		        <div>
		            <button type="submit" class="button green">
		                Add Project
		            </button>
		        </div>
		    </form>
		    		
		</div>
		
	</div>
	
</main>


@endsection

@section('scripts')
<script>
	
var pickerstart = new Pikaday({
    field: document.getElementById('datepickerstart'),
    format: 'YYYY-MM-DD',
    onSelect: function() {
        console.log(this.getMoment().format('YYYY-MM-DD'));
    }
});

swatch.init();

</script>
@endsection