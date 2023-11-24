const ready = (callback) => {
	if (document.readyState != "loading") callback();
	else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {


	/*
	* Prevent CF7 form duplication emails
	*/
	let cf7_forms_submit = document.querySelectorAll('.wpcf7-form .wpcf7-submit');

	if (cf7_forms_submit) {
		cf7_forms_submit.forEach((element) => {

			element.addEventListener('click', (e) => {

				let form = element.closest('.wpcf7-form');

				if (form.classList.contains('submitting')) {
					e.preventDefault();
				}

			});

		});
	}


	/* SCRIPTS GO HERE */



	// wcl-enter-pass

	if (document.querySelector('.wcl-enter-pass')) {
		let section = document.querySelector('.wcl-enter-pass');

		section.querySelector('input[name="password"]').addEventListener("input", function () {
			let inputField = this;
			let inputValue = inputField.value;

			// Remove any non-digit characters
			inputValue = inputValue.replace(/\D/g, '');

			// Truncate to at most four digits
			if (inputValue.length > 4) {
				inputValue = inputValue.slice(0, 4);
			}

			inputField.value = inputValue;
		});


		section.querySelector('.data-form').addEventListener('submit', function (e) {
			e.preventDefault()
			let form = this

			let password = form.querySelector('input').value
			let tree_id = section.getAttribute('data-tree-id')

			let data_req = {
				action: 'enter_password_check',
				password: password,
				tree_id: tree_id,
			}

			form.querySelector('.data-form-pass').classList.remove('mod-error')

			if (form.querySelector('.data-form-notify')) {
				form.querySelector('.data-form-notify').remove()
			}

			let xhr = new XMLHttpRequest();
			xhr.open('POST', wcl_obj.ajax_url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

			xhr.onload = function (data) {
				if (xhr.status >= 200 && xhr.status < 400) {
					var data = JSON.parse(xhr.responseText);

					if (data.error) {
						let tag = '<div class="data-form-notify">' + data.error + '</div>'
						form.insertAdjacentHTML('beforeend', tag)
						form.querySelector('.data-form-pass').classList.add('mod-error')
					} else if (data.submit) {
						form.querySelector('.data-form-pass').classList.remove('mod-error')
						if (form.querySelector('.data-form-notify')) {
							form.querySelector('.data-form-notify').remove()
						}
						// Reload the current page
						location.href = location.href;
					}
				};
			};

			data_req = new URLSearchParams(data_req).toString();
			xhr.send(data_req);
		})
	}


	/* 
	.data-siblings
	*/
	function wcl_data_siblings() {
		if (document.querySelector('.data-siblings')) {
			let section = document.querySelector('.data-siblings');

			section.querySelectorAll('.data-siblings-delete-button').forEach(element => {
				element.addEventListener('click', function (e) {
					e.stopPropagation()
					this.closest('.data-siblings-item').remove()
				})
			});

			// New Task

			const taskInput = document.getElementById("brothers_and_sisters");
			const addTaskButton = document.getElementById("brothers_and_sisters_add");
			const taskList = document.getElementById("brothers_and_sisters_list");

			addTaskButton.addEventListener("click", function () {
				const taskText = taskInput.value.trim();

				if (taskText !== "") {
					const taskItem = document.createElement("li");
					const taskSpan = document.createElement("span");
					taskSpan.textContent = taskText;
					taskItem.classList.add("data-siblings-item");

					const deleteButton = document.createElement("div");
					deleteButton.textContent = "Видалити";
					deleteButton.classList.add("data-siblings-delete-button");

					deleteButton.addEventListener("click", function (e) {
						e.stopPropagation()
						this.closest('.data-siblings-item').remove()
					});

					taskItem.appendChild(taskSpan);
					taskItem.appendChild(deleteButton);
					taskList.appendChild(taskItem);
					taskInput.value = "";
				}
			});
		}

	}


	/* 
	.data-voice
	*/

	function wcl_data_voice() {
		if (document.querySelector('.data-inner-three .data-voice')) {
			let section = document.querySelector('.data-inner-three .data-voice');

			const audioInput = document.getElementById("audio_recording");

			section.querySelector('.data-voice-field-delete-audio').addEventListener('click', function (e) {
				section.querySelector('input').value = '';
				section.querySelector('span').textContent = "Додати аудіо";
				section.classList.add('deleted')
				this.classList.remove('show')
			})

			audioInput.addEventListener("change", function () {
				const selectedFile = audioInput.files[0];
				if (selectedFile) {
					section.querySelector('span').textContent = selectedFile.name;
					section.classList.remove('deleted')
					section.querySelector('.data-voice-field-delete-audio').classList.add('show')
				} else {
					section.querySelector('span').textContent = "Додати аудіо";
				}
			});
		}
	}




	/* 
	wcl-b2-img-loader
	*/

	function wcl_img_loader() {
		if (document.querySelector('.wcl-b2-img-loader')) {

			let section = document.querySelector('.wcl-b2-img-loader');

			function wclEncodeImgtoBase64(element) {
				let img_new = document.createElement('img');

				let avatar = section.querySelector('.data-img img');
				let img = element.files[0];

				let reader = new FileReader();
				reader.readAsDataURL(img);
				reader.onload = function () {
					img_new.src = reader.result;
					section.querySelector('label').appendChild(img_new);
				}
			}

			section.querySelector('input').addEventListener('change', function (event) {
				if (this.files[0].size > 2000000) {
					alert('Image size exceeds 2MB');
					return;
				}
				let file = this.files[0];
				let fileType = file["type"];
				let validImageTypes = ["image/gif", "image/jpeg", "image/png"];
				if (!validImageTypes.includes(fileType)) {
					alert('The image must be in valid formats (gif, jpg, png)');
					return;
				}

				wclEncodeImgtoBase64(this)

				if (!document.querySelector('.wcl-member-popup').classList.contains('mod-edit')) {
					let popup = document.querySelector('.wcl-member-popup')

					let post_id = popup.getAttribute('data-post-id');
					let picture = popup.querySelector('input[name="picture"]').files[0]

					var fd = new FormData();

					fd.append("action", "member_add_picture");
					fd.append("post_id", post_id);
					fd.append("picture", picture);

					var xhr = new XMLHttpRequest();
					xhr.open('POST', wcl_obj.ajax_url, true);
					xhr.onload = function (data) {
						if (xhr.status >= 200 && xhr.status < 400) {
							var data = JSON.parse(xhr.responseText);
							//	console.log(data)
						}
					};

					xhr.send(fd);
				}
			})
		}
	}



	// Submit Member Form Edit

	function member_edit_info_submit() {
		let popup = document.querySelector('.wcl-member-popup');

		if (document.querySelector('.wcl-member-popup form.data-inner-three')) {
			let section = document.querySelector('.wcl-member-popup form.data-inner-three')

			section.addEventListener('submit', function (e) {
				e.preventDefault()
				let post_id = document.querySelector('.wcl-member-popup').getAttribute('data-post-id');
				let form = this;
				let picture = form.querySelector('input[name="picture"]').files[0]
				let audio_recording = form.querySelector('input[name="audio_recording"]').files[0]
				let full_name = form.querySelector('input[name="full_name"]').value
				let date_of_birth = form.querySelector('input[name="date_of_birth"]').value

				let place_of_birth = form.querySelector('input[name="place_of_birth"]').value
				let biography = form.querySelector('textarea[name="biography"]').value
				let date_of_death = form.querySelector('input[name="date_of_death"]').value
				let burial_place = form.querySelector('input[name="burial_place"]').value

				let audio_deleted = '';

				if (form.querySelector('.data-voice.deleted')) {
					audio_deleted = true;
				}

				// brothers_and_sisters

				let bro_and_sis_items = document.querySelectorAll(".data-siblings-item");
				let bro_and_sis_items_vals = [];

				bro_and_sis_items.forEach(function (element) {
					bro_and_sis_items_vals.push(element.querySelector('span').textContent);
				});

				let bro_and_sis_items_vals_joined = bro_and_sis_items_vals.join(", ");

				var fd = new FormData();

				if (popup.classList.contains('add-new-member')) {
					fd.append("action", "member_info_add_new");
				} else {
					fd.append("action", "member_info_update");
				}

				fd.append("post_id", post_id);
				fd.append("picture", picture);
				fd.append("audio_recording", audio_recording);
				fd.append("full_name", full_name);
				fd.append("date_of_birth", date_of_birth);
				fd.append("place_of_birth", place_of_birth);
				fd.append("biography", biography);
				fd.append("brothers_and_sisters", bro_and_sis_items_vals_joined);
				fd.append("date_of_death", date_of_death);
				fd.append("burial_place", burial_place);
				fd.append("audio_deleted", audio_deleted);

				if (popup.classList.contains('add-new-member')) {
					fd.append("new_member_data", section.getAttribute('data-new-member'));
				}

				if (form.querySelector('.data-form-notify')) {
					form.querySelector('.data-form-notify').remove()
				}

				form.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled')
				form.querySelector('.data-form-loader').classList.add('active')

				var xhr = new XMLHttpRequest();
				xhr.open('POST', wcl_obj.ajax_url, true);
				xhr.onload = function (data) {
					if (xhr.status >= 200 && xhr.status < 400) {
						var data = JSON.parse(xhr.responseText);

						form.querySelector('button[type="submit"]').removeAttribute('disabled')
						form.querySelector('.data-form-loader').classList.remove('active')

						if (data.error) {
							let tag = '<div class="data-form-notify">' + data.error + '</div>'
							form.querySelector('.data-edit').insertAdjacentHTML('beforeend', tag)
						} else if (data.submit) {
							let tag = '<div class="data-form-notify">' + data.submit + '</div>'
							form.querySelector('.data-edit').insertAdjacentHTML('beforeend', tag)
						}

					}
				};

				xhr.send(fd);
			})

		}
	}




	/* 
	popup_member_edit_info_btn
	 */

	function popup_member_edit_info_btn() {
		let section = document.querySelector('.data-edit-btn')

		section.addEventListener('click', function (e) {
			e.preventDefault()

			let post_id = document.querySelector('.wcl-member-popup').getAttribute('data-post-id')

			let data_req = {
				action: 'member_info_edit',
				post_id: post_id,
			}

			let xhr = new XMLHttpRequest();
			xhr.open('POST', wcl_obj.ajax_url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

			xhr.onload = function (data) {
				if (xhr.status >= 200 && xhr.status < 400) {
					var data = JSON.parse(xhr.responseText);
					document.querySelector('.wcl-member-popup .data-inner-two').remove()
					document.querySelector('.wcl-member-popup').classList.add('mod-edit')

					if (data.post) {
						document.querySelector('.wcl-member-popup .data-inner').insertAdjacentHTML('beforeend', data.post)
						wcl_img_loader()
						wcl_data_voice()
						wcl_data_siblings()
						member_edit_info_submit()
						popup_btn_back()
					}
				};
			};
			data_req = new URLSearchParams(data_req).toString();
			xhr.send(data_req);
		})
	}



	// Event Load Member Ifno
	function event_load_member_info() {
		wcl_img_loader();

		popup_btn_back()

		// popup_member_edit_info_btn
		popup_member_edit_info_btn();

		// data-voice-btn

		if (document.querySelector('.wcl-member-popup .data-voice-btn')) {
			let popup = document.querySelector('.wcl-member-popup')

			popup.querySelector('.data-voice-btn').addEventListener('click', function (e) {
				let audio = popup.querySelector('.data-voice audio');

				if (audio.paused) {
					audio.play();
					if (popup.querySelector('.data-voice-btn').classList.contains('pause')) {
						popup.querySelector('.data-voice-btn').classList.remove('pause');
					}
					popup.querySelector('.data-voice-btn').classList.add('play');
				} else {
					audio.pause();
					if (popup.querySelector('.data-voice-btn').classList.contains('play')) {
						popup.querySelector('.data-voice-btn').classList.remove('play');
					}
					popup.querySelector('.data-voice-btn').classList.add('pause');
				}
			})
		}
	}



	/* 
	.wcl-member-popup .data-btn-back
	*/
	function popup_btn_back() {
		if (document.querySelector('.wcl-member-popup .data-btn-back')) {
			let section = document.querySelector('.wcl-member-popup');

			section.querySelector('.data-btn-back').addEventListener('click', function (e) {
				section.classList.remove('active')
				document.querySelector('body').classList.remove('overflow-hidden')
				section.querySelector('.data-inner').classList.remove('active')

				if (section.querySelector('.data-inner-two')) {
					section.querySelector('.data-inner-two').remove()
				}

				if (section.querySelector('.data-inner-three')) {
					section.querySelector('.data-inner-three').remove()
				}
			})
		}
	}




	/* 
	.wcl-member-popup
	*/

	if (document.querySelector('.wcl-member-popup')) {
		let section = document.querySelector('.wcl-member-popup');



		// remove_data_member_info

		function remove_data_member_info() {
			if (section.querySelector('.wcl-member-popup .data-inner-two')) {
				section.querySelector('.wcl-member-popup .data-inner-two').remove()
			}

			if (section.querySelector('.wcl-member-popup .data-inner-three')) {
				section.querySelector('.wcl-member-popup .data-inner-three').remove()
			}
		}

		// Event Close Popup

		section.querySelector('.data-close').addEventListener('click', function (e) {
			section.classList.remove('active')
			document.querySelector('body').classList.remove('overflow-hidden')
			section.querySelector('.wcl-member-popup .data-inner').classList.remove('active')
			remove_data_member_info()
		})

		section.querySelector('.data-overlay').addEventListener('click', function (e) {
			section.classList.remove('active')
			document.querySelector('body').classList.remove('overflow-hidden')
			section.querySelector('.wcl-member-popup .data-inner').classList.remove('active')
			remove_data_member_info()
		})

		section.querySelector('.data-inner-out').addEventListener('click', function (e) {
			if (!e.target.closest('.data-inner')) {
				section.classList.remove('active')
				document.querySelector('body').classList.remove('overflow-hidden')
				section.querySelector('.wcl-member-popup .data-inner').classList.remove('active')
				remove_data_member_info()
			}
		})
	}



	// wcl-section-2

	if (document.querySelector('.wcl-section-2')) {
		let section = document.querySelector('.wcl-section-2');
		let popup = document.querySelector('.wcl-member-popup');

		/* 
		data-add-new
		 */
		if (document.querySelector('.data-add-new')) {
			let add_new = document.querySelector('.data-add-new');

			add_new.addEventListener('click', function (e) {
				let level = section.getAttribute('data-level')
				level = parseInt(level)

				if (level > 3) {
					return
				}

				let level_class = '.data-lvl-' + level
				let level_class_new = '.data-lvl-' + (level + 1)

				add_new.classList.remove("mod-level-" + level);
				add_new.classList.add("mod-level-" + (level + 1));

				section.querySelectorAll(level_class).forEach(element => {
					element.classList.add('mod-level-line-active')
				});

				section.querySelectorAll(level_class_new).forEach(element => {
					element.classList.add('mod-level-active')
				});

				section.setAttribute('data-level', level + 1)
			})
		}

		// Load Popup Member Info

		section.querySelector('.data-list').addEventListener('click', function (e) {
			if (e.target.closest('.data-parent.mod-empty')) {
				e.preventDefault()

				let item = e.target.closest('.data-parent')
				let side_of_tree = item.getAttribute('data-side-tree')
				let hierarchy_index = item.getAttribute('data-hierarchy-index')
				let family_tree = section.getAttribute('data-tree-id')

				let data_req = {
					action: 'member_info_edit',
					state: 'new_member',
					side_of_tree: side_of_tree,
					hierarchy_index: hierarchy_index,
					family_tree: family_tree,
				}

				popup.classList.add('active')
				popup.classList.add('add-new-member')
				document.querySelector('body').classList.add('overflow-hidden')

				let xhr = new XMLHttpRequest();
				xhr.open('POST', wcl_obj.ajax_url, true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				xhr.onload = function (data) {
					if (xhr.status >= 200 && xhr.status < 400) {
						var data = JSON.parse(xhr.responseText);

						document.querySelector('.wcl-member-popup').classList.add('mod-edit')
						popup.querySelector('.data-inner').classList.add('active')

						if (data.post) {
							document.querySelector('.wcl-member-popup .data-inner').insertAdjacentHTML('beforeend', data.post)
							wcl_img_loader()
							wcl_data_voice()
							wcl_data_siblings()
							member_edit_info_submit()
							popup_btn_back()
						}
					};
				};

				data_req = new URLSearchParams(data_req).toString();
				xhr.send(data_req);
			} else {
				if (e.target.closest('.data-parent')) {
					e.preventDefault()

					let item = e.target.closest('.data-parent')
					let post_id = item.getAttribute('data-post-id')

					let data_req = {
						action: 'member_info',
						post_id: post_id,
					}

					popup.setAttribute('data-post-id', post_id);
					popup.classList.add('active')
					document.querySelector('body').classList.add('overflow-hidden')

					let xhr = new XMLHttpRequest();
					xhr.open('POST', wcl_obj.ajax_url, true);
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
					xhr.onload = function (data) {
						if (xhr.status >= 200 && xhr.status < 400) {
							var data = JSON.parse(xhr.responseText);

							document.querySelector('.wcl-member-popup .data-inner').insertAdjacentHTML('beforeend', data.post)
							popup.querySelector('.data-inner').classList.add('active')
							event_load_member_info()
						};
					};
					data_req = new URLSearchParams(data_req).toString();
					xhr.send(data_req);
				}
			}



		})
	}



});