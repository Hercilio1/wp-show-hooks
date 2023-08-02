// Function to open the sidebar modal
function openModal() {
	document.querySelector("#wp-show-hooks").style.display = "block";
	document.querySelector("#wp-show-hooks .sidebar-modal").style.right = "0";
}

// Function to close the sidebar modal
function closeModal() {
	document.querySelector("#wp-show-hooks").style.display = "none";
	document.querySelector("#wp-show-hooks .sidebar-modal").style.right = "-250px";
}

// Function to add items to the list dynamically
function addItemToList(item) {
	const itemList = document.querySelector("#wp-show-hooks .hooks-list");
	console.log('debug:itemList', itemList)
	const li = document.createElement("li");
	li.textContent = item;
	itemList.appendChild(li);
}

document.addEventListener("DOMContentLoaded", () => {
	console.log('OIii');
	// Example: adding items to the list
	addItemToList("Item 1");
	addItemToList("Item 2");
	addItemToList("Item 3");

	openModal();

	// Event listener for the close button
	document.getElementById("closeModalBtn").addEventListener("click", closeModal);
});
console.log('OIii2');
