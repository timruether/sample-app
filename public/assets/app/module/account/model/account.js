
define([
	'backbone',
	'marionette'
], function(Backbone, Marionette)
{
	var AccountModel = Backbone.Model.extend(
	{
		defaults: {
			email: '',
			firstname: '',
			lastname: '',
			password: ''
		},

		parse: function (response, xhr)
		{
			if (_.isObject(response.data))
			{
				return response.data;
			}

			return response;
		},

		savedata: function ()
		{
			var me = this;

			this.save({}, {error: function (response, xhr)
			{
				me.trigger('account:error', JSON.parse(xhr.responseText), xhr);
			}});
		},

		url: 'api/v1/account'
	});

	return AccountModel;
});
