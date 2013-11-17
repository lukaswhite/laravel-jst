Laravel JST
===========

A simple package for generating JST templates (for Backbone apps, for example) from within Laravel.

##Say What?

You might well be used to developing Backbone views like this:


	MyApp.Views.SomeView = Backbone.View.extend({    
		template: _.template('<ul><% _.each(items, function(item){ %><li><%= item %></li><% }); %></ul>'),    
		el: '#some-element',
 
  
This is all fine and dandy for simple structures, but can quickly get unwieldly if you're building markup of any significant size or complexity.  It can also lead to all sorts of issues around readability.

One alternative is to put more complex templates into separate HTML files:


	// file: folder/template.html

	<ul>
		<% _.each(items, function(item){ %>
		<li><%= item %></li>
		<% }); %>
	</ul>

Each time you want to render a template, you can load in the template via AJAX.  Great for development - pretty atrocious for performance, as it'll fire off untold numbers of HTTP requests.

[Using JST](http://ricostacruz.com/backbone-patterns/#jst_templates) allows you to develop templates in this way - i.e. separate files, organised into a hierarchy - but "collapse" them into variables which are available via a single JS file (which can of course be incorporated into a larger Javascript file using, for example, the RequireJS optimiser or Google Closure Compiler).

This involves a file like this:


	// file: jst.js

	var JST = JST || {};
	JST['app/templates/folder/template.html'] = _.template('<ul><% _.each(items, function(item){ %><li><%= item %></li><% }); %></ul>');
	JST['app/templates/folder/template2.html'] = _.template('...');
	JST['app/templates/folder2/template.html'] = _.template('...');
	// etc...


Basically, this package creates the file above for you.  


##Usage


Generate your JST file by entering the following command in your terminal:

	php artisan jst:generate


Or alternatively, you can have it "watch" your templates directory (and any sub-directories) for changes, and recompile the file for you:

	php artisan jst:watch

You can use JST during development like this:

	// file: namespace.js
	
	define([
		// Libs
		"jquery",
		"use!underscore",
		"use!backbone"
	],

	function($, _, Backbone) {
	  // Put application wide code here

	  return {
	    // This is useful when developing if you don't want to use a
	    // build process every time you change a template.
    	//
	    // Delete if you are using a different template loading method.
	    fetchTemplate: function(path, done) {
      		var JST = window.JST = window.JST || {};
			var def = new $.Deferred();

			// Should be an instant synchronous way of getting the template, if it
			// exists in the JST object.
			if (JST[path]) {        
				if (_.isFunction(done)) {
					done(JST[path]);
				}

				return def.resolve(JST[path]);
			}

			// Fetch it asynchronously if not available from JST, ensure that
			// template requests are never cached and prevent global ajax event
			// handlers from firing.
			$.ajax({
				url: path,
				type: "get",
				dataType: "text",
				cache: false,
				global: false,

				success: function(contents) {
					JST[path] = _.template(contents);

					// Set the global JST cache and return the template
					if (_.isFunction(done)) {
						done(JST[path]);
					}

					// Resolve the template deferred
					def.resolve(JST[path]);
				}
			});

			// Ensure a normalized return value (Promise)
			return def.promise();
		},

	  };
	});

Then in your application code:

	MyApp.Views.SomeView = Backbone.View.extend({
		template: "app/templates/folder/someview.html",        
    	render: function(done) {      
			namespace.fetchTemplate(this.template, function(tmpl) {        
				view.el.innerHTML = tmpl({model: view.model.toJSON() });
				if (_.isFunction(done)) {
					done(view.el);
				}  
			});
		}
	// …
	
	
	
	
## Using it Outside of Laravel

There's no reason why this code can't be re-purposed to work outside of Laravel - perhaps I'll get a chance at some point, but feel free to have a stab at it.  All the dependencies are managed via Composer.

