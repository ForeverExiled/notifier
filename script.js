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

function set_minimum_date(dt_picker) {
    const now = new Date();
    const today = `${now.getFullYear()}-${(now.getMonth() + 1 + "").padStart(2, "0")}-${(now.getDate() + "").padStart(2, "0")}`;
    dt_picker.min = `${today}T00:00`;
    if (dt_picker.parentElement.id === "form_create") {
        dt_picker.value = `${today}T${(now.getHours() + "").padStart(2, "0")}:${(now.getMinutes() + 1 + "").padStart(2, "0")}`;
    }
}

document.addEventListener("DOMContentLoaded", function () {
	if (dt_picker = document.querySelector("input[type=datetime-local]")) {
        set_minimum_date(dt_picker);
	}
});
