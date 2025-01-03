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
    }
}
