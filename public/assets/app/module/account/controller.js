define([
	'require',
	'marionette'
], function(lrequire, Marionette)
{
	var controller = {

		initialize: function (options)
		{
			this.options = options;
		},

		/**
		 * Register new account
		 */
		create: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/createAccount'
			], function(AccountModel, CreateAccountView)
			{
				var createAccountView = new CreateAccountView({
					app: App,
					model: new AccountModel()
				});

				App.root.show(createAccountView);
			});
		},

		/**
		 * Show account view
		 */
		show: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/modifyAccount'
			], function(AccountModel, ModifyAccountView)
			{
				var accountModel = new AccountModel();

				accountModel.fetch({
					success: function()
					{
						var modifyAccountView = new ModifyAccountView({app: App, model: accountModel});

						App.root.show(modifyAccountView);
					}
				});
			});
		}

	};

	return controller;
});
