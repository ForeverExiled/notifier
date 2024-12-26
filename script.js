async function handle(payload) {
    const response = await fetch("/core/handler.php", {
        method: "post",
        body: payload,
    });

    if (response.ok) {
	const json = await response.json();

	console.log(json);
    }
}
