# Vaccination Management System - Project Documentation
## Overview
This project is a Vaccination Management System built using Laravel and deployed with Docker. The system supports user registration, vaccine center scheduling, and status updates. It utilizes the Laravel queue system for background job processing, a scheduler for scheduled tasks, and email notifications for reminders.

## Features

1. **User Registration:** Users can register with their details, including selecting a vaccine center.
2. **User Scheduling:** Users are assigned to vaccine centers based on availability, with serial numbers assigned in a first-come, first-served manner.
3. **Status Updates:** The system updates user status (e.g., Scheduled, Vaccinated) based on scheduled dates.
4. **Email Notifications:** Daily email reminders are sent to users with upcoming vaccination dates.
5. **Background Job Processing:** The Laravel queue system is used for processing long-running tasks such as sending emails.
6. **Scheduled Tasks:** Daily tasks such as updating user statuses are handled by Laravel's scheduling system.
7. **Local time:** Timezone is the based on **Asia/Dhaka**


## How to run

* I have written Dockerfile to build image of this app. To keep the app fully environment independent I have added **docker compose**. In the compose I have added the **MySQL** service for Database, **phpmyadmin** for Database client, **nginx** for webserver and the app image.
* Before run the please seed the **VaccineCenterSeeder**.
* I have also included **DummyUserSeeder** to test, Although it is optional to seed.

There is a mail notification system in this app,
To incorporate SMS notifications along with the existing email notifications for vaccine schedule reminders, 
here are the changes and steps that I need to be taken:
* Integrate an SMS service such as Twilio, Nexmo, or any other reliable SMS provider.
* Install the necessary package for the chosen SMS service.
* Add environment variables for the SMS provider credentials in the .env.
* Just like the **VaccinationReminder** email class, I have to create a new class for SMS notifications.
* Then I can easily add this into que service to send notification uninterruptedly.

## CI/CD
For demonstrating simple CI/CD I have used the GitHub action workflow, It basically builds the docker image and push docker hub.

**Note:** To work mail server properly please provide the actual credentials
