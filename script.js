async function foo(payload) {
    const body = JSON.stringify(payload);
    const response = await fetch("/handler.php", {
        method: "post",
        body: body,
    }).then((response) => console.log(response.json));
}