# ESAS-WT-MP
Examination Staff Allotment System - Mini Project
IInd Year Computer Engineering Web Technology - Mini Project

## Before you read or go through the project...
Please see, this is my first project in Web Technology with PHP & MySQL DB. :)

## Features
- Register and Login for Staff.
- Update/Delete Staff Members.
- Staff Availabilty Entry.
- Examination Schedule Entry.
- Update/Delete Examination.
- Algorithm to allot the Staff using the best fit.

## Algorithm
The algorithm first selects the available staff members. It then sorts the staff members in descending order of number of times
to be alloted. Once sorted, it uses Round-Robin to allot the staff members to various classes/classrooms .
Once the allocaion is complete, it generates a table showing the allotments. If not, it displays an error.
