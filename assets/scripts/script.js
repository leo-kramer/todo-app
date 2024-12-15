const deleteTask = (taskIndex) => {
	fetch("delete-task.php", {
		method: "DELETE",
		headers: {
			"Content-Type": "application/json",
		},
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
	stylePriorityButton()
	updatePriority()

	updateStatus()
})

const stylePriorityButton = () => {
	const dropdownButton = document.querySelectorAll(".btn.btn-secondary")

	dropdownButton.forEach((button) => {
		const priority = button.textContent.trim()

		switch (priority) {
			case "Immediate":
				button.style.backgroundColor = "var(--bs-purple)"
				break
			case "High":
				button.style.backgroundColor = "var(--bs-red)"
				break
			case "Normal":
				button.style.backgroundColor = "var(--bs-green)"
				break
			case "Low":
				button.style.backgroundColor = "var(--bs-blue)"
				break
			default:
				button.style.backgroundColor = "var(--bs-dark)"
				break
		}
	})
}

const updatePriority = () => {
	// When selecting a new priority
	document.querySelectorAll(".dropdown-menu .dropdown-item").forEach((item) => {
		item.addEventListener("click", (e) => {
			e.preventDefault()

			// Find the dropdown button and task being changed
			const dropdown = e.target.closest(".dropdown")
			const task = dropdown.closest("li")

			// Get text from the selected priority (since it will change to that)
			const newPriority = e.target.textContent.trim()
			const taskIndex = task.getAttribute("data-index")

			// Update status
			fetch("update-task.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify({ index: taskIndex, priority: newPriority }),
			})
				.then((response) => response.text()) // Convert PHP response to text
				.then((data) => {
					console.log(data) // Log the response
					window.location.reload() // Reload the page to update information
				})
				.catch((error) => console.error("Error:", error))
		})
	})
}

const updateStatus = () => {
	const tasks = document.querySelectorAll(".list-group-item")
	const statusSections = document.querySelectorAll("main > section")

	tasks.forEach((task) => {
		task.addEventListener("dragstart", (e) => {
			e.dataTransfer.setData("text/plain", e.target.dataset.index)
		}) // dataTransfer since during the drop event there is no way of knowing which tasks got droppped there
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

			// Update status
			fetch("update-task.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
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
}
