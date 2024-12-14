const deleteTask = (taskIndex) => {
	fetch("delete-task.php", {
		method: "DELETE",
		body: JSON.stringify({ index: taskIndex }),
	})
		.then((response) => response.text()) // Convert PHP response to text
		.then((data) => {
			console.log(data) // Log the response

			window.location.reload() // Reload the page to update information
		})
		.catch((error) => console.error("Error:", error))
}

// Fetch all tasks once everyone has been loaded
document.addEventListener("DOMContentLoaded", () => {
	const tasks = document.querySelectorAll(".task-item")
	const statusSections = document.querySelectorAll("main > section")

	tasks.forEach((task) => {
		task.addEventListener("dragstart", (e) => {
			e.dataTransfer.setData("text/plain", e.target.dataset.index)
		})
	})

	statusSections.forEach((status) => {
		status.addEventListener("dragover", (e) => {
			e.preventDefault()
		})

		status.addEventListener("drop", (e) => {
			e.preventDefault()
			const taskIndex = e.dataTransfer.getData(
				"text/plain",
				e.target.dataset.index
			)
			const newStatus = status.dataset.status

			console.log(taskIndex)
			console.log(newStatus)

			// Update status
			fetch("update-task.php", {
				method: "POST",
				body: JSON.stringify({ index: taskIndex, status: newStatus }),
			})
				.then((response) => response.text()) // Convert PHP response to text
				.then((data) => {
					console.log(data) // Log the response

					window.location.reload() // Reload the page to update information
				})
				.catch((error) => console.error("Error:", error))
		})
	})
})
