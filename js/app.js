/*--------------------------------------------------------------------------------------------------------------------*/

function __tfg_reset_color(target)
{
	setTimeout(() => {

		target.find('a').removeAttr('style');

	}, 4000);
}

/*--------------------------------------------------------------------------------------------------------------------*/

$(document).ready(() => {

	/*----------------------------------------------------------------------------------------------------------------*/

	$(document).on('click', '[data-tfg-action="sync"]', (e) => {

		/*------------------------------------------------------------------------------------------------------------*/

		const target = $(e.currentTarget);

		e.preventDefault();

		/*------------------------------------------------------------------------------------------------------------*/

		target.find('i').removeClass('fa-shopping-basket').addClass('fa-spinner fa-spin');

		/*------------------------------------------------------------------------------------------------------------*/

		$.ajax({
			url: target.attr('data-tfg-uri'),
			data: {action: 'synchronize'},
			dataType: 'json',
			method: 'GET',
		}).done(() => {

			target.find('i').removeClass('fa-spinner fa-spin').addClass('fa-shopping-basket');
			target.find('a').attr('style', 'color: green !important');
	
		}).fail(() => {
	
			target.find('i').removeClass('fa-spinner fa-spin').addClass('fa-shopping-basket');
			target.find('a').attr('style', 'color: red !important');
	
		}).always(() => {
	
			__tfg_reset_color(target);
		});
	
		/*------------------------------------------------------------------------------------------------------------*/
	});

	/*----------------------------------------------------------------------------------------------------------------*/

	$('ul[data-collection-holder="repos"] li').each((idx, item) => {

		/*------------------------------------------------------------------------------------------------------------*/

		const rep = $(item);

		const div = $('<div class="form-field"></div>');
		const btn = $(`<button class="button" type="button">Synchronize</button>`);
		const msg = $(`<span class="xxxxxxxx"></span>`);

		rep.append(div);
		div.append(btn);
		div.append(msg);

		/*------------------------------------------------------------------------------------------------------------*/

		btn.click((e) => {

			const theme = rep.find(`[name="data\\[repos\\]\\[${idx}\\]\\[theme\\]"]`).val();
			const repoURL = rep.find(`[name="data\\[repos\\]\\[${idx}\\]\\[repo_url\\]"]`).val();
			const repoBranch = rep.find(`[name="data\\[repos\\]\\[${idx}\\]\\[repo_branch\\]"]`).val();

			$.ajax({
				url: $('[data-tfg-action="sync"]').attr('data-tfg-uri'),
				data: {action: 'check', theme: theme, repoURL: repoURL, repoBranch: repoBranch},
				dataType: 'json',
				method: 'GET',
			}).done((data) => {

				if(data.status === 'success')
				{
					msg.attr('style', 'margin-left: 1rem !important; color: #32B643 !important;').text('Synchronization success');
				}
				else
				{
					msg.attr('style', 'margin-left: 1rem !important; color: #E85600 !important;').text('Synchronization error');
				}

			}).fail(() => {

				alert('Error');	
			});
		});

		/*------------------------------------------------------------------------------------------------------------*/
	});

	/*----------------------------------------------------------------------------------------------------------------*/
});

/*--------------------------------------------------------------------------------------------------------------------*/
