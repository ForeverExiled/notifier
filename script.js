const handler_url = "/core/handler.php";

let nearest_todo = null;

if (Notification.permission !== "granted") {
	Notification.requestPermission().then((permission) => {
		if (permission !== "granted") {
			alert("Для работы приложения требуется разрешение пользователя на отображение уведомлений!");
		}
	});
}

function show_context_menu(event) {
    const context_menu = document.getElementById("ctx__menu");
    context_menu.style.top = `${event.clientY}px`;
    context_menu.style.left = `${event.clientX}px`;

    document.getElementById("ctx__btn-edit").href = `/pages/edit.php?id=${event.target.dataset.id}`;
    document.getElementById("ctx__btn-delete").setAttribute("data-id", event.target.dataset.id);

    document.getElementById("ctx__wrapper").classList.add("show");
}

function hide_context_menu() {
    document.getElementById("ctx__wrapper").classList.remove("show");
}

function confirm_delete(event) {
    if (confirm("Подтверди удаление!")) {
        fetch(handler_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: event.target.dataset.id,
                action: "delete",
            }),
        });

		if (event.target.dataset.id == nearest_todo.id) {
			fetch_nearest_todo();
		}

        const todo = document.querySelector(`div[data-id="${event.target.dataset.id}"]`);
        if (sibling = (todo.nextElementSibling || todo.previousElementSibling)) {
            sibling.remove();
        }
        todo.remove();

        const list = document.querySelector("section.list");
        if (!list.childElementCount) {
            list.classList.remove("show");
            document.querySelector("p.empty-list").classList.add("show");
        }
    }
}

function go_off(todo) {
	new Notification("🦋Напоминалка🦋", {
		body: todo.text,
		timestamp: Date.parse(todo.datetime),
		requireInteraction: true,
	});
}

function validate_textarea() {
    const textarea = document.querySelector("textarea");
    if (textarea.validity.valueMissing) {
        textarea.setCustomValidity("Напиши то, о чем нужно напомнить!");
    } else {
        textarea.setCustomValidity("");
    }
    textarea.reportValidity();
    return !textarea.validity.customError;
}

function validate_datetime() {
    const dt_picker = document.querySelector("input[type=datetime-local]");
    if (dt_picker.validity.valueMissing) {
        dt_picker.setCustomValidity("Выбери денек и время!");
    } else if (Date.parse(dt_picker.value) - Date.now() <= 0) {
        dt_picker.setCustomValidity("Нельзя поставить напоминание в прошлое!");
    } else {
        dt_picker.setCustomValidity("");
    }
    dt_picker.reportValidity();
    return !dt_picker.validity.customError;
}

function validate(event) {
    if (validate_textarea() && validate_datetime()) {
        return;
    }
    event.preventDefault();
}

function format_date(date) {
	return `${date.getFullYear()}-${(date.getMonth() + 1 + "").padStart(2, "0")}-${(date.getDate() + "").padStart(2, "0")}`;
}

function set_minimum_date(dt_picker) {
    const now = new Date();
    const today = format_date(now);
    dt_picker.min = `${today}T00:00`;
    if (dt_picker.parentElement.id === "form_create") {
		const minutes = now.getMinutes() + 1 + "";
		const hours = now.getHours() + (minutes === "60" ? 1 : 0) + "";
        dt_picker.value = `${minutes === "60" && hours === "24" ? format_date(new Date(Date.now() + 86400000)) : today}T${(hours === "24" ? "00" : hours).padStart(2, "0")}:${(minutes === "60" ? "00" : minutes).padStart(2, "0")}`;
    }
}

async function fetch_nearest_todo() {
	nearest_todo = await fetch(`${handler_url}?q=nearest`).then(response => response.json());
}

fetch_nearest_todo();

const interval_id = setInterval(() => {
	if (nearest_todo instanceof Array) {
		clearInterval(interval_id);
	} else if(Date.parse(nearest_todo.datetime) <= Date.now()) {
		if (todo_node = document.querySelector(`div[data-id="${nearest_todo.id}"]`)) {
			todo_node.removeAttribute("onclick");
			todo_node.classList.add("notified");
			todo_node.firstElementChild.addEventListener("click", confirm_delete);
			todo_node.firstElementChild.classList.add("trash-can");
		}
		go_off(nearest_todo);
		fetch(handler_url, {
			method: "POST",
			headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: nearest_todo.id,
                action: "complete",
				notified: 1,
            }),
		}).then(fetch_nearest_todo);
	}
}, 5000);

function recalculate_elements_size(elements) {
	elements.forEach(element => {
		element.width = window.innerWidth;
		element.height = window.innerHeight;
	});
}

document.addEventListener("DOMContentLoaded", function () {
	const back_canvas = document.getElementById("back_canvas");
	const back_context = back_canvas.getContext("2d", {
		willReadFrequently: true,
	});
	const front_canvas = document.getElementById("front_canvas");
	const front_context = front_canvas.getContext("2d");
	const video = document.querySelector("video");
	recalculate_elements_size([back_canvas, front_canvas, video]);
	window.addEventListener("resize", function () {
		recalculate_elements_size([back_canvas, front_canvas, video]);
	});
	
	setInterval(() => {
		back_context.drawImage(video, 0, 0, back_canvas.width, back_canvas.height);
		const frame = back_context.getImageData(0, 0, back_canvas.width, back_canvas.height);
		const pixels = frame.data;

		for (let i = 0; i < pixels.length; i += 4) {
			if (pixels[i + 1] > 0) {
				pixels[i + 3] = 0;
			} else {
				pixels[i + 0] = 255;
				pixels[i + 1] = 255;
				pixels[i + 2] = 255;
			}
		}

		front_context.putImageData(frame, 0, 0);
	}, 0);

	if (dt_picker = document.querySelector("input[type=datetime-local]")) {
        set_minimum_date(dt_picker);
	}
});
