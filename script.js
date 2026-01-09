const form = document.getElementById("todoForm");
const input = document.getElementById("taskInput");
const list = document.getElementById("todoList");

/* OLDAL BETÖLTÉSKOR */
document.addEventListener("DOMContentLoaded", loadTodos);

async function loadTodos() {
    const response = await fetch("getTodos.php");
    const todos = await response.json();

    list.innerHTML = "";

    todos.forEach(todo => {
        addTodoToList(todo.task);
    });
}

/* ÚJ TODO FELVÉTEL */
form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const task = input.value.trim();
    if (!task) return;

    const response = await fetch("insert.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            task: task,
            finished: 0
        })
    });

    const result = await response.json();

    if (result.success) {
        addTodoToList(task);
        input.value = "";
    } else {
        alert("Hiba történt");
    }
});

function addTodoToList(task) {
    const li = document.createElement("li");
    li.textContent = task;
    list.appendChild(li);
}
