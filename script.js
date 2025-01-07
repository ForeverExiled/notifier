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
        fetch("/core/handler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: event.target.dataset.id,
                action: "delete",
            }),
        });

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

function go_off() {
	// TODO: make browser play notification sound;
	/*
		Display alert. When user presses "OK", mark todo as fulfilled and go to the next one
	*/
    console.log(`going off at: ${Date.now().toLocaleString()}`);
}

function validate(event) {
    const dt_picker = document.querySelector("input[type=datetime-local]");
    const validity_state = dt_picker.validity;
    if (validity_state.valueMissing) {
        dt_picker.setCustomValidity("Выбери денек и время!");
    } else if (Date.parse(dt_picker.value) - Date.now() <= 0) {
        dt_picker.setCustomValidity("Нельзя поставить напоминание в прошлое!");
    } else {
        dt_picker.setCustomValidity("");
    }
    if (validity_state.customError) {
        event.preventDefault();
    }
    dt_picker.reportValidity();
}

let interval;

document.addEventListener("DOMContentLoaded", function () {
    const nearest_deadline = document.querySelector(".todo-item");
    if (nearest_deadline) {
        const timestamp = Date.parse(nearest_deadline.dataset.datetime);
        interval = setInterval(() => {
            if ((timestamp - Date.now()) <= 0) {
				clearInterval(interval);
                go_off();
            }
        }, 1000);
    }

    const dt_picker = document.querySelector("#form_create input[type=datetime-local]");
    console.log(dt_picker);
	if (dt_picker) {
        const now = new Date();
		dt_picker.value = `${now.getFullYear()}-${(now.getMonth() + 1 + "").padStart(2, "0")}-${(now.getDate() + "").padStart(2, "0")}T${(now.getHours() + "").padStart(2, "0")}:${(now.getMinutes() + 1 + "").padStart(2, "0")}`;
	}
});
