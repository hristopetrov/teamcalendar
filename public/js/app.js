var spinner = '<div class="spinner"><i class="spinner-icon"></i></div>';
var calendar = {
	
	ajaxurl: domain + '/calendar/',
	
    init: function() {
        this.loadListener();
        this.moveListener();
        this.dragable();
	    this.dropable();
    },
    
    loadListener: function() {
    	if ($('.js-calendar').length > 0) {
	    	var cal = $('.js-calendar');
	    	var start = cal.data('start');
	    	var length = cal.data('length');
	        calendar.getCalendar(start,length);
	    };
    },

    
    moveListener: function() {
    	$('.js-move-calendar').off('click').on('click',function(e){
	        e.preventDefault();
	    	var start = $('#calendar').data('start'); console.log(start);
	    	var length = $('#calendar').data('length');
	    	var move = $(this).data('move');
	        calendar.getCalendar(start,length,move);
	    });
    },
    
    dragable: function() {
    	$('.dragable').off('dragstart').on('dragstart',function(event){
		    event.originalEvent.dataTransfer.setData("text/html",this.outerHTML);
		   	event.originalEvent.dataTransfer.dropEffect = 'move';
	    });
    },
    
    dropable: function() {
	    $('.dropable').off('dragenter').on('dragenter',function(){
		    $(this).addClass('lightgray').on('dragleave',function(){
				$(this).removeClass('lightgray');  
		    });
	    });
	    $('.dropable').off('dragover').on('dragover',function(event){
		   	event.preventDefault(); 
		});
	    $('.dropable').off('drop').on('drop',function(event){
		    event.preventDefault();	
		    var slot = $(this);
		    slot.removeClass('lightgray');
			var data = event.originalEvent.dataTransfer.getData("text/html");
			var project_id = calendar.getId(data).data('project');
		    var date = slot.data('date');
		    var user_id = slot.data('user');
		    var busy = slot.data('busy');
		    var length = '1.0';
		    var tasks = [];
		    slot.children('.calendar-project').each(function () {
			    tasks.push($(this).data('id'));
			});
			if (project_id > 0) {
				if (busy==1 || tasks.length > 1) {
				    alert('This day is already full.');
				    slot.data('busy',1).removeClass('dropable');
				    calendar.dropable();
			    } else {
					if (tasks.length == '1.0') {
					    length = '0.5';
					    busy = 1;
					    if (team!==undefined) {
						    team.editTask(tasks[0],0.5);
						}
				    }
				    if (team!==undefined) {
	 				    team.addTask(user_id,date,project_id,length,busy,slot);
	 					var a = $(this).append(data);

				    }
				}
			} else {
				if (tasks.length > 0) {
					alert('Delete projects first!');
				} else {
					var away = calendar.getId(data).data('away');
				    calendar.addAway(date,user_id,away,slot);
				    $(this).append(data);
				}
			}	    
		});
	},
	//get the id of the project or away (vacation, illnes or other) depending on the browser
	getId: function(data){
		var isFirefox = typeof InstallTrigger !== 'undefined';
		var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
		var isChrome = !!window.chrome && !!window.chrome.webstore;
		if(isChrome){
			return $($.parseHTML(data)[1]);
		}else{
			return $(data);
		}
	},
    
    getCalendar: function(start,length,move) {
	    $('#calendar').append(spinner);
	    if (move != undefined) {
		    var url = calendar.ajaxurl+start+'/'+length+'/'+move;
	    } else {
		    var url = calendar.ajaxurl+start+'/'+length;
	    }
	    $.ajax({
		    url: url,
		    data: {},
		    error: function() {
			    alert('error');
		    },
		    success: function(data) {
			    $('#calendar').html(data.html);
			    $('#calendar').data('start',data.start);
			    calendar.dropable();
			    team.listeners();
		    },
	    });
    },
    
    addAway: function(date,user_id,away,slot) {
	    $.ajax({
		    headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
		    url: calendar.ajaxurl+'away/add',
		    method: 'POST',
		    data: {
			    'date': date,
			    'user_id': user_id,
			    'away': away
		    },
		    error: function() {
				slot.find('.vacation[data-away="'+away+'"]').remove();
			    alert('Could not save task.');
		    },
		    success: function(data) {
			    if (data.result) {
				    slot.attr('data-busy','1').removeClass('dropable');
				    slot.find('.vacation[data-away="'+away+'"]').attr('data-id',data.id);
				    calendar.dropable();
				    team.listeners();
			    }
		    },
	    });
    },
    
    
    delAway: function(id) {
	    $.ajax({
		    headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
		    url: calendar.ajaxurl+'away/del/'+id,
		    method: 'DELETE',
		    data: {
			    'date': date,
			    'user': user
		    },
		    error: function() {
				alert('Could not delete.');  
		    },
		    success: function(data) {
			    if (data.result){
				    let el = document.querySelector('.calendar-project[data-id="'+id+'"]');
				    let slot = el.closest('.calendar-slot');
				    slot.dataset.busy = 0;
    			    slot.classList.add('dropable');
				    calendar.dropable();
				    el.remove();
			    }
		    },
	    });
    },

};
calendar.init();

var team = {
	
	ajaxurl: domain + '/admin/ajax/',
	
    init: function() {
        this.getClientByName();
        this.listeners();

    },
    listeners: function(){
    	$('.js-del-task').off('click').on('click',function(event){
    		event.preventDefault();
    		let id = $(this).closest('.calendar-project').data('id');
    		team.delTask(id);
    	});

    },
    getClientByName: function() {
    	$('#client_search').autocomplete({
	        source: this.ajaxurl+'clients/search',
	        minLength: 3,
	        select: function( event, ui ) {
	            $('#client_id-auto').val(ui.item.id);
	            $('#client_name-auto').val(ui.item.name);
	        },
	        change: function(event, ui) {
	            $('#client_id-auto').val(ui.item ? ui.item.id : '');
	            $('#client_name-auto').val(ui.item ? ui.item.name : '');
	        }
	    });
    },
    
    addTask: function(user_id,date,project_id,length,busy,slot) {
	    $.ajax({
		    headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
		    url: team.ajaxurl+'calendar/new',
		    method: 'POST',
		    data: {
			    'date': date,
			    'user_id': user_id,
			    'project_id': project_id,
			    'length': length,
		    },
		    error: function() {
			    slot.find('.calendar-project[data-project="'+project_id+'"]').remove();
			    alert('Error: Could not save task.');			    
		    },
		    success: function(data) {
			    if (data.result) {
				    if (busy) {
					    slot.attr('data-busy','1').removeClass('dropable');
					    calendar.dropable();
				    }
	    		    slot.find('.calendar-project[data-project="'+project_id+'"]').attr('data-length',length);
	    		    slot.find('.calendar-project[data-project="'+project_id+'"]').attr('data-id',data.id);
	    		    team.listeners(); 
			    } else{
				    slot.find('.calendar-project[data-project="'+project_id+'"]').remove();
				    alert('Could not save task.');
			    }
			    
		    },
	    });
    },

    editTask: function(id,length) {
	    $.ajax({
		    headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },		    
		    url: team.ajaxurl+'calendar/edit/'+id,
		    method: 'PUT',
		    data: {
			    'length': length,
		    },
		    error: function() {
				alert('Could not save.'); 
		    },
		    success: function(data) {
			    if (data.result) {
				    el = document.querySelector('.calendar-project[data-id="'+id+'"]');
				    el.dataset.length = length;
				}
		    },
	    });
    },
    
    delTask: function(id) {
	    $.ajax({
		    headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
		    url: team.ajaxurl+'calendar/del/'+id,
		    method: 'DELETE',
		    data: {},
		    error: function() {
				alert('Could not delete.');  
		    },
		    success: function(data) {
		    	if(data.result){		
				    el = document.querySelector('.calendar-project[data-id="'+id+'"]');
				    let slot = el.closest('.calendar-slot');
				    slot.dataset.busy = 0;
				    slot.classList.add('dropable');
				    el.remove();
				    calendar.dropable();
		    	}
		    },
	    });
    },

};

team.init();


var swatch = {
	init: function() {
		var colorInput = document.getElementById('color');
		var colors = document.querySelectorAll('.swatch');
		Array.from(colors).forEach(swatch => {
		    swatch.addEventListener('click',function() {
				let color = this.style.backgroundColor; console.log(color);
				var hex_rgb = color.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/); 
				function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
				if (hex_rgb) {
					colorInput.value = hex(hex_rgb[1]) + hex(hex_rgb[2]) + hex(hex_rgb[3]);
					colorInput.style.borderBottom = '6px solid #'+colorInput.value;
				}
			});
		});
		colorInput.addEventListener('change',visualiseColor, false);
		function visualiseColor() {
			this.style.borderBottom = '6px solid #'+this.value;
			
		}
	}
}

