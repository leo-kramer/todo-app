const deleteTask = (taskIndex) => {
	fetch("delete-task.php", {
		method: "DELETE",
		body: JSON.stringify({ index: taskIndex }),
	})
		.then((response) => response.text()) // Convert PHP response to text
		.then((data) => {
			console.log(data) // Log the response
		})
		.catch((error) => console.error("Error:", error))

	window.location.reload() // Reload the page to update information
}
