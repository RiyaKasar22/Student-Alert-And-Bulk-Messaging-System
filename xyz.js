/* =====================================================
   STUDENT ALERT SYSTEM
   Frontend JavaScript
   Connected with PHP + MySQL Backend
===================================================== */


/* ================= API PATHS ================= */
const STUDENT_API = "/backend/students/";
const MESSAGE_API = "/backend/messages/";

/* ================= DATA ================= */

let students = [];
let classes = JSON.parse(localStorage.getItem("classes")) || [];
let messages = [];


/* ================= ELEMENTS ================= */

const studentCount = document.getElementById("studentCount");
const classCount = document.getElementById("classCount");
const messageCount = document.getElementById("messageCount");
const pendingCount = document.getElementById("pendingCount");

const studentTable = document.getElementById("studentTable");
const classTable = document.getElementById("classTable");

const historyTable = document.getElementById("historyTable");
const recentMessages = document.getElementById("recentMessages");


/* =====================================================
   LOAD STUDENTS FROM DATABASE
===================================================== */

async function loadStudents() {

    try {

        const response = await fetch(
            STUDENT_API + "get.php"
        );

        if (!response.ok) {
            throw new Error("Unable to connect to student API");
        }

        students = await response.json();
        populateStudentDropdown();

        displayStudents();

        updateDashboard();

    } catch (error) {

        console.error(error);

        studentTable.innerHTML = `
            <tr>
                <td colspan="5" style="text-align:center;color:red;">
                    Unable to load students from database.
                </td>
            </tr>
        `;

    }

}

const receiverSelect = document.getElementById("receiver");
const studentSelectBox = document.getElementById("studentSelectBox");
const studentSelect = document.getElementById("studentSelect");

receiverSelect.addEventListener("change", function () {
    studentSelectBox.style.display =
        this.value === "Student" ? "block" : "none";
});


function populateStudentDropdown() {
    // Specific student dropdown is not needed.
    // Messages will be sent to all students.
}



/* =====================================================
   LOAD MESSAGES
===================================================== */

async function loadMessages() {

    try {

        const response = await fetch(
            MESSAGE_API + "get.php"
        );

        if (!response.ok) {
            throw new Error("Message API not available");
        }

        messages = await response.json();

        updateDashboard();

        displayHistory();

    } catch (error) {

        console.log("Message API not connected yet.");

        messages = [];

        updateDashboard();

        displayHistory();

    }

}


/* =====================================================
   DASHBOARD
===================================================== */

function updateDashboard() {

    studentCount.textContent = students.length;

    classCount.textContent = classes.length;

    messageCount.textContent = messages.length;

    pendingCount.textContent = 0;

    displayRecentMessages();

}


/* =====================================================
   RECENT MESSAGES
===================================================== */

function displayRecentMessages() {

    if (messages.length === 0) {

        recentMessages.innerHTML = `
            <div class="empty">
                <i class="fa-regular fa-envelope"></i>
                <p>No messages yet.</p>
            </div>
        `;

        return;
    }


    let html = `
        <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>Message</th>
                    <th>Receiver</th>
                    <th>Date</th>
                </tr>

            </thead>

            <tbody>
    `;


    const recent =
        messages.slice(-5).reverse();


    recent.forEach(message => {

        html += `
            <tr>

                <td>${message.message || ""}</td>
<td>${message.recipient_count || 0} student(s)</td>
<td>${message.created_at || ""}</td>
            </tr>
        `;

    });


    html += `
            </tbody>
        </table>

        </div>
    `;


    recentMessages.innerHTML = html;

}


/* =====================================================
   PAGE NAVIGATION
===================================================== */

const navLinks =
    document.querySelectorAll(
        ".sidebar a[data-page]"
    );


navLinks.forEach(link => {

    link.addEventListener(
        "click",
        function(event) {

            event.preventDefault();

            const pageId =
                this.getAttribute("data-page");


            document
                .querySelectorAll(".page")
                .forEach(page => {

                    page.classList.remove(
                        "active-page"
                    );

                });


            document
                .getElementById(pageId)
                .classList.add("active-page");


            document
                .querySelectorAll(".sidebar li")
                .forEach(item => {

                    item.classList.remove("active");

                });


            this.parentElement.classList.add("active");


            if (pageId === "students") {

                loadStudents();

            }


            if (pageId === "classes") {

                displayClasses();

            }


            if (pageId === "history") {

                loadMessages();

            }

        }
    );

});


/* =====================================================
   SIDEBAR TOGGLE
===================================================== */

document
    .getElementById("menuBtn")
    .addEventListener("click", function() {

        document
            .getElementById("sidebar")
            .classList.toggle("collapsed");

    });


/* =====================================================
   STUDENT FORM
===================================================== */

document
    .getElementById("showStudentForm")
    .addEventListener("click", function() {

        const formBox =
            document.getElementById(
                "studentFormBox"
            );


        if (formBox.style.display === "block") {

            formBox.style.display = "none";

        } else {

            formBox.style.display = "block";

        }

    });


/* =====================================================
   ADD STUDENT TO DATABASE
===================================================== */

document
    .getElementById("studentForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const studentData = {

                name:
                    document
                        .getElementById("studentName")
                        .value.trim(),

                roll_no:
                    document
                        .getElementById("studentRoll")
                        .value.trim(),

                mobile:
                    document
                        .getElementById("studentPhone")
                        .value.trim(),

                email:
                    document
                        .getElementById("studentEmail")
                        ?.value.trim() || "",

                class:
                    document
                        .getElementById("studentClass")
                        .value.trim(),

                division:
                    document
                        .getElementById("studentDivision")
                        ?.value.trim() || "",

                attendance:
                    document
                        .getElementById("studentAttendance")
                        ?.value || 0,

                status:
                    "Active"

            };


            try {

                const response = await fetch(
                    STUDENT_API + "add.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body:
                            JSON.stringify(studentData)
                    }
                );


                const result =
                    await response.text();


                console.log(result);


                if (!response.ok) {

                    throw new Error(
                        "Failed to add student"
                    );

                }


                alert(
                    "Student added successfully!"
                );


                this.reset();


                document
                    .getElementById(
                        "studentFormBox"
                    )
                    .style.display = "none";


                await loadStudents();

            } catch (error) {

                console.error(error);

                alert(
                    "Error while adding student."
                );

            }

        }
    );


/* =====================================================
   DISPLAY STUDENTS
===================================================== */

function displayStudents() {

    studentTable.innerHTML = "";


    if (students.length === 0) {

        studentTable.innerHTML = `
            <tr>

                <td colspan="5"
                    style="text-align:center;color:#999;">

                    No students added yet.

                </td>

            </tr>
        `;

        return;

    }


    students.forEach(student => {

        studentTable.innerHTML += `

            <tr>

                <td>
                    ${student.name || ""}
                </td>

                <td>
                    ${student.roll_no || student.roll || ""}
                </td>

                <td>
                    ${student.class || student.className || ""}
                </td>

                <td>
                    ${student.mobile || student.phone || ""}
                </td>

                <td>

                    <button
                        class="delete-btn"
                        onclick="deleteStudent(${student.id})">

                        Delete

                    </button>

                </td>

            </tr>

        `;

    });

}


/* =====================================================
   DELETE STUDENT FROM DATABASE
===================================================== */

async function deleteStudent(id) {

    if (!confirm("Delete this student?")) {

        return;

    }


    try {

        const response = await fetch(
            STUDENT_API + "delete.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body: JSON.stringify({
                    id: id
                })

            }
        );


        const result =
            await response.text();


        console.log(result);


        if (!response.ok) {

            throw new Error(
                "Delete failed"
            );

        }


        alert(
            "Student deleted successfully!"
        );


        await loadStudents();


    } catch (error) {

        console.error(error);

        alert(
            "Error while deleting student."
        );

    }

}


/* =====================================================
   CLASSES
===================================================== */


/* Show class form */

document
    .getElementById("showClassForm")
    .addEventListener("click", function() {

        const formBox =
            document.getElementById(
                "classFormBox"
            );


        if (formBox.style.display === "block") {

            formBox.style.display = "none";

        } else {

            formBox.style.display = "block";

        }

    });


/* Add class */

document
    .getElementById("classForm")
    .addEventListener(
        "submit",
        function(event) {

            event.preventDefault();


            const newClass = {

                id: Date.now(),

                name:
                    document
                        .getElementById("className")
                        .value.trim(),

                teacher:
                    document
                        .getElementById("classTeacher")
                        .value.trim()

            };


            classes.push(newClass);


            localStorage.setItem(
                "classes",
                JSON.stringify(classes)
            );


            displayClasses();

            updateDashboard();


            this.reset();


            document
                .getElementById(
                    "classFormBox"
                )
                .style.display = "none";


            alert(
                "Class added successfully!"
            );

        }
    );


/* Display classes */

function displayClasses() {

    classTable.innerHTML = "";


    if (classes.length === 0) {

        classTable.innerHTML = `
            <tr>

                <td colspan="4"
                    style="text-align:center;color:#999;">

                    No classes added yet.

                </td>

            </tr>
        `;

        return;

    }


    classes.forEach(classItem => {

        const count =
            students.filter(student => {

                const studentClass =
                    student.class ||
                    student.className ||
                    "";

                return (
                    studentClass ===
                    classItem.name
                );

            }).length;


        classTable.innerHTML += `

            <tr>

                <td>
                    ${classItem.name}
                </td>

                <td>
                    ${classItem.teacher}
                </td>

                <td>
                    ${count}
                </td>

                <td>

                    <button
                        class="delete-btn"
                        onclick="deleteClass(${classItem.id})">

                        Delete

                    </button>

                </td>

            </tr>

        `;

    });

}


/* Delete class */

function deleteClass(id) {

    if (!confirm("Delete this class?")) {

        return;

    }


    classes =
        classes.filter(
            item => item.id !== id
        );


    localStorage.setItem(
        "classes",
        JSON.stringify(classes)
    );


    displayClasses();

    updateDashboard();

}


/* =====================================================
   SEND MESSAGE
===================================================== */

document
    .getElementById("messageForm")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const receiver =
                document
                    .getElementById("receiver")
                    .value;


            const text =
                document
                    .getElementById("messageText")
                    .value.trim();


            if (!receiver || !text) {

                alert(
                    "Please enter all details."
                );

                return;

            }


            const newMessage = {
    message: text,
    message_type: "SMS",
    sent_by: 1,
    student_ids: students.map(student => Number(student.id))
};


            try {

                const response = await fetch(
                    MESSAGE_API + "send.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body:
                            JSON.stringify(
                                newMessage
                            )

                    }
                );


                const result =
                    await response.text();


                console.log(result);


                if (!response.ok) {

                    throw new Error(
                        "Message sending failed"
                    );

                }


                alert(
                    "Message sent successfully!"
                );


                this.reset();


                await loadMessages();


                document
                    .querySelector(
                        '[data-page="history"]'
                    )
                    .click();


            } catch (error) {

                console.error(error);

                alert(
                    "Error while sending message."
                );

            }

        }
    );


/* =====================================================
   MESSAGE HISTORY
===================================================== */

function displayHistory() {

    historyTable.innerHTML = "";

    if (messages.length === 0) {
        historyTable.innerHTML = `
            <tr>
                <td colspan="3" style="text-align:center;color:#999;">
                    No messages sent yet.
                </td>
            </tr>
        `;
        return;
    }

    messages.slice().reverse().forEach(message => {

        historyTable.innerHTML += `
            <tr>
                <td>${message.message || ""}</td>
                <td>${message.recipient_count || 0} student(s)</td>
                <td>${message.created_at || ""}</td>
            </tr>
        `;

    });
}


/* =====================================================
   LOGOUT
===================================================== */

document
    .getElementById("logoutBtn")
    .addEventListener(
        "click",
        function(event) {

            event.preventDefault();

            alert(
                "Logout functionality will be connected later."
            );

        }
    );


/* =====================================================
   INITIAL LOAD
===================================================== */

loadStudents();

loadMessages();

displayClasses();

displayHistory();