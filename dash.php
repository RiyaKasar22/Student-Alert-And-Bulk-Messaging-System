<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Alert System</title>

    <link rel="stylesheet" href="abc.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<!-- TOP NAVBAR -->
<header class="topbar">

    <div class="brand">
        <i class="fa-solid fa-bars" id="menuBtn"></i>
        <span>Student Alert System</span>
    </div>

    <div class="admin">
        <span>Welcome, Admin</span>
        <i class="fa-solid fa-circle-user"></i>
    </div>

</header>


<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <ul>

            <li class="active">
                <a href="#" data-page="dashboard">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="#" data-page="students">
                    <i class="fa-solid fa-users"></i>
                    <span>Students</span>
                </a>
            </li>

            <li>
                <a href="#" data-page="classes">
                    <i class="fa-solid fa-chalkboard"></i>
                    <span>Classes</span>
                </a>
            </li>

            <li>
                <a href="#" data-page="send-message">
                    <i class="fa-regular fa-envelope"></i>
                    <span>Send Message</span>
                </a>
            </li>

            <li>
                <a href="#" data-page="history">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Message History</span>
                </a>
            </li>

            <li>
                <a href="#" id="logoutBtn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="content">

        <!-- DASHBOARD -->
        <section id="dashboard" class="page active-page">

            <h1>Dashboard</h1>

            <div class="cards">

                <div class="card blue">
                    <i class="fa-solid fa-user"></i>

                    <div>
                        <p>Total Students</p>
                        <h2 id="studentCount">0</h2>
                    </div>
                </div>


                <div class="card green">
                    <i class="fa-solid fa-chalkboard"></i>

                    <div>
                        <p>Total Classes</p>
                        <h2 id="classCount">0</h2>
                    </div>
                </div>


                <div class="card orange">
                    <i class="fa-solid fa-paper-plane"></i>

                    <div>
                        <p>Messages Sent</p>
                        <h2 id="messageCount">0</h2>
                    </div>
                </div>


                <div class="card purple">
                    <i class="fa-solid fa-clock"></i>

                    <div>
                        <p>Pending Messages</p>
                        <h2 id="pendingCount">0</h2>
                    </div>
                </div>

            </div>


            <div class="box">

                <div class="box-title">
                    Recent Messages
                </div>

                <div id="recentMessages">
                    <div class="empty">
                        <i class="fa-regular fa-envelope"></i>
                        <p>No messages yet.</p>
                    </div>
                </div>

            </div>

        </section>


        <!-- STUDENTS -->
        <section id="students" class="page">

            <div class="page-heading">
                <h1>Students</h1>

                <button class="primary-btn" id="showStudentForm">
                    <i class="fa-solid fa-plus"></i>
                    Add Student
                </button>
            </div>


            <div class="box form-box" id="studentFormBox">

                <h3>Add Student</h3>

                <form id="studentForm">

                    <input type="text"
                           id="studentName"
                           placeholder="Student Name"
                           required>

                    <input type="text"
                           id="studentRoll"
                           placeholder="Roll Number"
                           required>

                    <input type="text"
                           id="studentClass"
                           placeholder="Class"
                           required>

                    <input type="tel"
                           id="studentPhone"
                           placeholder="Phone Number"
                           required>

                    <button class="primary-btn" type="submit">
                        Add Student
                    </button>

                </form>

            </div>


            <div class="box">

                <div class="box-title">
                    Student List
                </div>

                <div class="table-container">

                    <table>

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Roll No.</th>
                                <th>Class</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="studentTable">
                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        <!-- CLASSES -->
        <section id="classes" class="page">

            <div class="page-heading">

                <h1>Classes</h1>

                <button class="primary-btn" id="showClassForm">
                    <i class="fa-solid fa-plus"></i>
                    Add Class
                </button>

            </div>


            <div class="box form-box" id="classFormBox">

                <h3>Add Class</h3>

                <form id="classForm">

                    <input type="text"
                           id="className"
                           placeholder="Class Name"
                           required>

                    <input type="text"
                           id="classTeacher"
                           placeholder="Class Teacher"
                           required>

                    <button class="primary-btn" type="submit">
                        Add Class
                    </button>

                </form>

            </div>


            <div class="box">

                <div class="box-title">
                    Class List
                </div>

                <div class="table-container">

                    <table>

                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Students</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="classTable">
                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        <!-- SEND MESSAGE -->
        <section id="send-message" class="page">

            <h1>Send Message</h1>

            <div class="box message-form">

                <form id="messageForm">

                    <label>Send To</label>

                    
<label>Send To</label>

<select id="receiver" required>
    <option value="All Students">All Students</option>
</select>




                    <label>Message</label>

                    <textarea id="messageText"
                              rows="6"
                              placeholder="Type your message here..."
                              required></textarea>


                    <button class="primary-btn" type="submit">

                        <i class="fa-solid fa-paper-plane"></i>
                        Send Message

                    </button>

                </form>

            </div>

        </section>


        <!-- MESSAGE HISTORY -->
        <section id="history" class="page">

            <h1>Message History</h1>

            <div class="box">

                <div class="box-title">
                    Sent Messages
                </div>

                <div class="table-container">

                    <table>

                        <thead>

                            <tr>
                                <th>Message</th>
                                <th>Receiver</th>
                                <th>Date</th>
                            </tr>

                        </thead>

                        <tbody id="historyTable">
                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>


<script src="xyz.js"></script>

</body>
</html>