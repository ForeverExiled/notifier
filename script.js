function show_context_menu(e) {
    hide_context_menu();

    const wrapper = document.createElement("div");
    wrapper.id = "wrapper";
    wrapper.addEventListener("click", hide_context_menu);

    const context_menu = document.createElement("div");
    context_menu.className = "context-menu";
    context_menu.style.top = `${e[0].clientY}px`;
    context_menu.style.left = `${e[0].clientX}px`;

    const action_edit = document.createElement("a");
    action_edit.href = `/pages/edit.php?id=${e[1]}`;
    action_edit.text = "Изменить";

    const action_delete = document.createElement("div");
    action_delete.setAttribute("data-id", e[1]);
    action_delete.textContent = "Удалить";
    action_delete.addEventListener("click", confirm_delete);

    context_menu.append(action_edit, document.createElement("hr"), action_delete);
    wrapper.append(context_menu);
    document.body.append(wrapper);
}

function hide_context_menu() {
    const wrapper = document.getElementById("wrapper");
    if (wrapper) {
        wrapper.remove();
    }
}

function confirm_delete(e) {
    if (confirm("Подтверди удаление!")) {
        fetch("/core/handler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: this.dataset.id,
                action: "delete",
            }),
        });

        const todo = document.querySelector(`div[data-id="${this.dataset.id}"]`);
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
});
