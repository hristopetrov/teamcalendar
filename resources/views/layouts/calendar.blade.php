<div id="calendar-members" class="tat-f-0-0">
			
	@if (count($users) > 0)
				
		@foreach ($users as $user)
			
			<div class="calendar-member right">
				{{ $user->firstname }} {{ $user->lastname }}
			</div>
			
		@endforeach
		
	@endif
	
</div>

<div id="calendar-days" class="tat-f-1-1 tat-g" data-start="{{ $start }}" data-length="{{ $length }}">
	
	@foreach ($calendar as $day)
		<div class="calendar-day tat-u-1 tat-u-sm-1-2 tat-u-md-1-4 tat-u-lg-1-{{ $length }} @if($day['date']==$today) today @endif" data-date="{{ $day['date'] }}">
			
			<div class="calendar-day-th mint tat-c tat-right">
				<span class="date">{{ $day['day'] }}</span>	
				<span class="weekday">{{ $day['weekday'] }}</span>
			</div>
			
			<div class="calendar-day-td tat-c">			
				
				@foreach ($day['tasks'] as $user_id => $user_tasks)
					
					<div class="calendar-slot tat-c dropable" 
						data-date="{{ $day['date'] }}" 
					    data-user="{{ $user_id }}"
						@if (count($user_tasks) > 1 OR (!empty($user_tasks[0]['away'])))
							data-busy="1"
						@else
							data-busy="0"
						@endif
						>
								
						@if (count($user_tasks) > 0)
							
							@foreach ($user_tasks as $task)
							
								@if ($task['away']=='vacation') 
									<div class="calendar-project tat-f-0-0 tat-r tat-middle lightgray vacation" style="" data-length="1.0" data-away="vacation" data-id="{{ $task['id'] }}"> 
										<span class="away-name tat-f-1-1">Vacation</span>
										<div class="tat-f-0-0 tat-s-middle project-actions">
											<span class="tat-right-lg"><i class="js-del-task material-icons" >close</i></span>
										</div>
									</div>
								@elseif ($task['away']=='sick')
									<div class="calendar-project tat-f-0-0 tat-r tat-middle lightgray vacation" style="" data-length="1.0" data-away="sick" data-id="{{ $task['id'] }}">
										<span class="away-name tat-f-1-1">Illness</span>
										<div class="tat-f-0-0 tat-s-middle project-actions">
											<span class="tat-right-lg"><i class="js-del-task material-icons" >close</i></span>
										</div>
									</div>
								@elseif ($task['away']=='other')
									<div class="calendar-project tat-f-0-0 tat-r tat-middle lightgray vacation" style="" data-length="1.0" data-away="other" data-id="{{ $task['id'] }}">
										<span class="away-name tat-f-1-1">Away</span>
										<div class="tat-f-0-0 tat-s-middle project-actions">
											<span class="tat-right-lg"><i class="js-del-task material-icons" >close</i></span>
										</div>
									</div>
								@else 
									<div class="calendar-project tat-f-0-0 tat-r green @if (ColorsHelper::isDark($task['color'])) darkcolor @endif" 
										@if (!empty($task['color'])) style="background-color: #{{$task['color']}}" @endif
										data-id="{{ $task['id'] }}"
										data-project="{{ $task['project_id'] }}"
										data-length="{{ $task['length'] }}"
										>
										<div class="tat-f-1-1 tat-c tat-center">
											<span class="project-client">{{ $task['client_name'] }}</span>
											<span class="project-name">{{ $task['name'] }}</span>
										</div>
										<div class="tat-f-0-0 tat-s-middle project-actions">
											<span class="tat-right-lg"><i class="js-del-task material-icons text-white" >close</i></span>
										</div>
										

									</div>
								@endif
								
							@endforeach	
							
						@endif
						
					</div>
					
				@endforeach
				
			</div>
			
		</div>
	@endforeach
	
</div>