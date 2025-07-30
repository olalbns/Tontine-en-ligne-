const dropdown = document.getElementById("dropdown");
const profile = document.querySelector(".profile");
const sidebar = document.getElementById("sidebar");
const fonction = document.getElementById("fonction");

function respo() {
    const isSidebarHidden = sidebar.style.display === "none" || sidebar.style.display === "";
    profile.style.display = isSidebarHidden ? "flex" : "none";
    sidebar.style.display = isSidebarHidden ? "block" : "none";
    fonction.style.display = isSidebarHidden ? "none" : "block";
    sidebar.style.transition = "all 0.3s";
    profile.style.transition = "all 0.3s";
}

// Example: attach to dropdown click if needed
// dropdown.addEventListener('click', respo);

// document.getElementById('paymentType').addEventListener('change', function () {
//   // Hide all fields first
//   document.getElementById('mobileMoneyFields').classList.add('hidden');
//   document.getElementById('cardFields').classList.add('hidden');
//   // document.getElementById('paypalFields').classList.add('hidden');

//   // Show the relevant fields based on selection
//   switch (this.value) {
//     case 'mobile_money':
//       document.getElementById('mobileMoneyFields').classList.remove('hidden');
//       break;
//     case 'Carte_Bancaire':
//       document.getElementById('cardFields').classList.remove('hidden');
//       break;
//     // case 'PayPal':
//     //   document.getElementById('paypalFields').classList.remove('hidden');
//     //   break;
//   }
// });
