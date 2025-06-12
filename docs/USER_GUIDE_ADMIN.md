# 👨‍💼 HRMS Administrator User Guide

## 📋 Table of Contents
1. [Getting Started](#getting-started)
2. [Admin Dashboard](#admin-dashboard)
3. [Employee Management](#employee-management)
4. [Organization Setup](#organization-setup)
5. [Attendance Management](#attendance-management)
6. [Leave Management](#leave-management)
7. [Payroll Administration](#payroll-administration)
8. [Performance Management](#performance-management)
9. [Recruitment & Hiring](#recruitment--hiring)
10. [Reports & Analytics](#reports--analytics)
11. [System Configuration](#system-configuration)
12. [User Account Management](#user-account-management)
13. [Security & Permissions](#security--permissions)
14. [Troubleshooting](#troubleshooting)

---

## 🚀 Getting Started

### Admin Access
1. **Login URL**: `[your-domain]/admin/login`
2. **Credentials**: Use admin email and password from deployment
3. **First Login**: Change default password immediately
4. **Two-Factor Auth**: Enable 2FA for enhanced security

### Admin Dashboard Overview
Your admin dashboard provides:
- **Key Metrics**: Employee count, attendance stats, pending approvals
- **Recent Activity**: Latest system activities and changes
- **Quick Actions**: Common administrative tasks
- **System Status**: Health checks and alerts
- **Calendar Events**: Upcoming company events and deadlines

---

## 🏠 Admin Dashboard

### Dashboard Widgets
**Employee Statistics:**
- Total active employees
- New hires this month
- Pending applications
- Employee distribution by department

**Attendance Overview:**
- Today's attendance rate
- Late arrivals
- Absent employees
- Overtime hours logged

**Pending Approvals:**
- Leave requests awaiting approval
- Timesheet corrections
- Employee document submissions
- Performance review submissions

### Quick Actions Panel
- Add new employee
- Approve pending leaves
- Generate reports
- System announcements
- Backup database

---

## 👥 Employee Management

### Adding New Employees

**Step 1: Basic Information**
1. Go to **Employees > Add New**
2. Fill employee details:
   - Personal information (name, contact, address)
   - Government IDs (SSS, TIN, PhilHealth, Pag-IBIG)
   - Emergency contacts

**Step 2: Employment Details**
1. Set employment information:
   - Employee ID (auto-generated or manual)
   - Job title and department
   - Hire date and employment status
   - Salary and pay grade
   - Work schedule and shift

**Step 3: System Access**
1. Create user account:
   - Email address (username)
   - Temporary password
   - Role and permissions
   - Account activation

**Step 4: Documents**
1. Upload required documents:
   - Resume/CV
   - Valid IDs
   - Medical certificates
   - Background check results

### Employee Records Management

**Viewing Employee Information:**
1. Go to **Employees > All Employees**
2. Search by name, ID, or department
3. Click employee name to view full profile
4. Review all tabs: Information, Documents, Attendance, etc.

**Updating Employee Records:**
1. Navigate to employee profile
2. Click **Edit** on relevant section
3. Make necessary changes
4. Save and document changes
5. Notify employee of updates

**Employee Status Changes:**
- **Probationary to Regular**: Update employment status
- **Transfers**: Change department/position
- **Promotions**: Update job title and salary
- **Terminations**: Process separation procedures

### Bulk Operations
**Import Employees:**
1. Download employee import template
2. Fill template with employee data
3. Upload CSV/Excel file
4. Review and confirm import
5. Generate login credentials

**Export Employee Data:**
1. Go to **Employees > Export**
2. Select data fields to include
3. Choose export format (CSV, Excel, PDF)
4. Apply filters if needed
5. Download generated file

---

## 🏢 Organization Setup

### Company Information
1. Go to **Admin > Company Settings**
2. Update company details:
   - Company name and logo
   - Address and contact information
   - Business registration details
   - Tax identification numbers

### Department Management
**Adding Departments:**
1. Navigate to **Organization > Departments**
2. Click **Add Department**
3. Enter department details:
   - Department name
   - Description
   - Department head
   - Budget allocation (if applicable)

**Department Hierarchy:**
1. Set parent-child relationships
2. Assign department heads
3. Configure approval workflows
4. Set budget limits

### Job Family & Titles
**Job Families:**
1. Go to **Organization > Job Families**
2. Create job family categories:
   - Executive
   - Management
   - Professional
   - Technical
   - Administrative

**Job Titles:**
1. Navigate to **Organization > Job Titles**
2. Add specific positions:
   - Job title name
   - Job family assignment
   - Pay grade range
   - Required qualifications

### Locations & Branches
1. Go to **Organization > Locations**
2. Add office locations:
   - Location name and address
   - Contact information
   - Timezone settings
   - Local compliance requirements

---

## 📅 Attendance Management

### Attendance Monitoring
**Daily Attendance:**
1. Go to **Attendance > Daily Records**
2. View real-time attendance:
   - Employees present/absent
   - Late arrivals
   - Early departures
   - Break times

**Attendance Reports:**
1. Navigate to **Attendance > Reports**
2. Generate attendance summaries:
   - Monthly attendance sheets
   - Individual attendance records
   - Department-wise attendance
   - Overtime reports

### Attendance Policies
**Work Schedules:**
1. Go to **Attendance > Schedules**
2. Create work schedules:
   - Regular hours (e.g., 9AM-6PM)
   - Flexible schedules
   - Shift schedules
   - Weekend schedules

**Attendance Rules:**
1. Set attendance policies:
   - Grace period for late arrivals
   - Break time allocations
   - Overtime calculation rules
   - Holiday work policies

### Timesheet Management
**Approving Corrections:**
1. Go to **Attendance > Corrections**
2. Review correction requests:
   - Employee justification
   - Supporting documentation
   - Manager recommendations
3. Approve or reject with comments

**Bulk Corrections:**
1. Select multiple records
2. Apply corrections to multiple employees
3. Document reason for changes
4. Notify affected employees

---

## 🏖️ Leave Management

### Leave Policies Setup
**Leave Types Configuration:**
1. Go to **Leaves > Leave Types**
2. Configure leave categories:
   - Vacation Leave (VL)
   - Sick Leave (SL)
   - Maternity/Paternity Leave
   - Emergency Leave
   - Bereavement Leave

**Leave Allocation:**
1. Set annual leave credits
2. Configure accrual rates
3. Set maximum carry-over limits
4. Define leave year periods

### Leave Request Processing
**Pending Approvals:**
1. Navigate to **Leaves > Pending Requests**
2. Review leave applications:
   - Employee details and leave balance
   - Leave dates and duration
   - Reason for leave
   - Work coverage arrangements

**Approval Workflow:**
1. First-level: Immediate supervisor
2. Second-level: Department head
3. Final-level: HR approval
4. Special cases: Executive approval

**Processing Requests:**
1. Review all request details
2. Check leave balance availability
3. Verify supporting documents
4. Approve/reject with comments
5. Notify employee of decision

### Leave Analytics
**Leave Reports:**
1. Go to **Leaves > Reports**
2. Generate leave analytics:
   - Leave utilization rates
   - Department-wise leave trends
   - Seasonal leave patterns
   - Leave balance summaries

**Leave Calendar:**
1. View organization-wide leave calendar
2. Identify peak leave periods
3. Plan staffing requirements
4. Avoid scheduling conflicts

---

## 💰 Payroll Administration

### Payroll Setup
**Pay Periods:**
1. Go to **Payroll > Settings**
2. Configure pay schedules:
   - Bi-weekly, semi-monthly, or monthly
   - Pay period start/end dates
   - Pay dates and cutoffs

**Salary Components:**
1. Set up pay components:
   - Basic salary
   - Allowances (transportation, meal, etc.)
   - Overtime rates
   - Bonuses and incentives

**Deductions Setup:**
1. Configure mandatory deductions:
   - Income tax (BIR rates)
   - SSS contributions
   - PhilHealth premiums
   - Pag-IBIG contributions
2. Optional deductions:
   - Loans and advances
   - Insurance premiums
   - Union dues

### Payroll Processing
**Monthly Payroll Run:**
1. Go to **Payroll > Process Payroll**
2. Select pay period
3. Review attendance data
4. Calculate overtime and deductions
5. Generate payroll register
6. Review and approve payroll
7. Generate pay slips

**Payroll Verification:**
1. Review payroll calculations
2. Check for anomalies or errors
3. Verify tax computations
4. Confirm bank transfer amounts
5. Generate payroll reports

### Payroll Reports
**Standard Reports:**
1. **Payroll Register**: Complete payroll summary
2. **Tax Reports**: BIR filing requirements
3. **SSS Reports**: Monthly remittance reports
4. **PhilHealth Reports**: Premium payments
5. **Pag-IBIG Reports**: Contribution summaries

**Year-End Processing:**
1. Generate 13th month pay
2. Prepare BIR Form 2316
3. Annual tax summaries
4. Benefits and bonuses calculation

---

## 📊 Performance Management

### Performance Review Setup
**Review Cycles:**
1. Go to **Performance > Settings**
2. Configure review periods:
   - Probationary reviews (3-6 months)
   - Annual performance reviews
   - Project-based reviews
   - Continuous feedback cycles

**Evaluation Criteria:**
1. Set performance metrics:
   - Job-specific competencies
   - Behavioral indicators
   - Goal achievement measures
   - Development areas

### Performance Review Process
**Creating Review Templates:**
1. Navigate to **Performance > Templates**
2. Design evaluation forms:
   - Rating scales (1-5, percentage, etc.)
   - Competency areas
   - Goal-setting sections
   - Development planning

**Review Assignment:**
1. Go to **Performance > Reviews**
2. Assign reviews to employees
3. Set review deadlines
4. Notify reviewers and reviewees
5. Track completion status

**Review Monitoring:**
1. Monitor review progress
2. Send reminders for overdue reviews
3. Escalate incomplete reviews
4. Ensure quality of feedback

### Performance Analytics
**Performance Reports:**
1. Generate performance summaries
2. Identify top performers
3. Track improvement trends
4. Department performance comparisons

**Talent Management:**
1. Identify high-potential employees
2. Succession planning
3. Training needs analysis
4. Career development paths

---

## 👔 Recruitment & Hiring

### Job Board Management
**Creating Job Postings:**
1. Go to **Recruitment > Job Board**
2. Create new job posting:
   - Job title and description
   - Required qualifications
   - Salary range
   - Application deadline
   - Job location

**Application Management:**
1. Navigate to **Recruitment > Applications**
2. Review incoming applications:
   - Applicant information
   - Resume and documents
   - Application responses
   - Resume evaluator scores (if available)

### Hiring Process
**Application Screening:**
1. Review applications against criteria
2. Use resume evaluation tools
3. Shortlist qualified candidates
4. Schedule initial interviews

**Interview Management:**
1. Schedule interviews with hiring managers
2. Record interview feedback
3. Compare candidate evaluations
4. Make hiring recommendations

**Offer Management:**
1. Generate job offers
2. Negotiate terms and conditions
3. Track offer responses
4. Prepare employment contracts

### Pre-Employment Processing
**Document Collection:**
1. Collect required documents:
   - Government IDs
   - Educational certificates
   - Employment history
   - Medical certificates
   - Background check results

**Onboarding Preparation:**
1. Create employee records
2. Set up system accounts
3. Prepare welcome materials
4. Schedule orientation sessions

---

## 📈 Reports & Analytics

### Standard Reports
**Employee Reports:**
1. **Employee Roster**: Complete employee list
2. **Employee Directory**: Contact information
3. **Organizational Chart**: Company structure
4. **Birthday Lists**: Monthly birthday reports

**Attendance Reports:**
1. **Daily Time Records**: Daily attendance logs
2. **Monthly Attendance**: Summary by month
3. **Overtime Reports**: Overtime hours tracking
4. **Late/Absent Reports**: Attendance violations

**Leave Reports:**
1. **Leave Balances**: Current leave credits
2. **Leave Utilization**: Leave usage patterns
3. **Leave Calendar**: Organization leave schedule
4. **Leave Trends**: Historical leave analysis

**Payroll Reports:**
1. **Payroll Register**: Complete payroll data
2. **Tax Reports**: Government reporting requirements
3. **Bank Reports**: Salary transfer files
4. **Cost Center Reports**: Department-wise costs

### Custom Reports
**Report Builder:**
1. Go to **Reports > Custom Reports**
2. Select data sources
3. Choose fields to include
4. Apply filters and sorting
5. Generate and save reports

**Scheduled Reports:**
1. Set up automated report generation
2. Schedule delivery via email
3. Define recipient lists
4. Set recurring schedules

### Analytics Dashboard
**Key Metrics:**
1. Employee turnover rates
2. Recruitment effectiveness
3. Attendance trends
4. Performance indicators
5. Training completion rates

**Data Visualization:**
1. Charts and graphs
2. Trend analysis
3. Comparative reports
4. Predictive analytics

---

## ⚙️ System Configuration

### General Settings
**System Preferences:**
1. Go to **Admin > System Settings**
2. Configure basic settings:
   - Date and time formats
   - Currency settings
   - Language preferences
   - Timezone configuration

**Email Configuration:**
1. Set up SMTP settings
2. Configure email templates
3. Test email delivery
4. Set sender information

### Security Configuration
**Password Policies:**
1. Set password requirements:
   - Minimum length
   - Character complexity
   - Expiration periods
   - History restrictions

**Session Management:**
1. Configure session timeouts
2. Set maximum concurrent sessions
3. Enable/disable remember me
4. Force logout settings

### Integration Settings
**Third-Party Services:**
1. Configure API connections
2. Set up single sign-on (if available)
3. Integrate with payroll systems
4. Connect with time tracking devices

**Backup Configuration:**
1. Set up automated backups
2. Configure backup schedules
3. Set retention periods
4. Test backup restoration

---

## 👤 User Account Management

### Creating User Accounts
**Admin Users:**
1. Go to **Accounts > Administrators**
2. Create admin accounts:
   - Full admin access
   - HR manager access
   - Department manager access
   - Limited admin access

**Employee Accounts:**
1. Navigate to **Accounts > Employees**
2. Create employee accounts:
   - Basic employee access
   - Supervisor access
   - Department head access
   - Custom role access

### Role & Permission Management
**Predefined Roles:**
1. **Super Admin**: Full system access
2. **HR Manager**: HR module access
3. **Department Head**: Department management
4. **Supervisor**: Team management
5. **Employee**: Basic employee features

**Custom Permissions:**
1. Create custom permission sets
2. Assign specific module access
3. Set data visibility restrictions
4. Configure approval authorities

### Account Maintenance
**Password Resets:**
1. Go to **Accounts > Password Resets**
2. Reset user passwords
3. Force password changes
4. Send reset instructions

**Account Deactivation:**
1. Temporarily disable accounts
2. Permanent account removal
3. Data retention policies
4. Access log reviews

---

## 🔒 Security & Permissions

### Access Control
**Module-Level Security:**
1. Control access to HR modules
2. Set department data visibility
3. Restrict sensitive information
4. Configure approval workflows

**Data Security:**
1. Implement data encryption
2. Secure file uploads
3. Audit trail maintenance
4. Privacy compliance

### Audit & Monitoring
**Activity Logs:**
1. Go to **Admin > Activity Logs**
2. Monitor user activities:
   - Login/logout events
   - Data modifications
   - Permission changes
   - Security violations

**Security Reports:**
1. Generate security summaries
2. Identify suspicious activities
3. Track failed login attempts
4. Monitor data access patterns

### Compliance Management
**Data Privacy:**
1. Implement privacy policies
2. Manage data retention
3. Handle data subject requests
4. Ensure GDPR compliance (if applicable)

**Regulatory Compliance:**
1. Maintain employment records
2. Generate regulatory reports
3. Ensure tax compliance
4. Follow labor law requirements

---

## 🔧 Troubleshooting

### Common Issues

**System Performance:**
- **Slow Loading**: Clear cache, optimize database
- **Timeouts**: Increase server timeout settings
- **Memory Issues**: Upgrade server resources

**User Access Problems:**
- **Login Failures**: Check credentials, reset passwords
- **Permission Errors**: Verify user roles and permissions
- **Account Lockouts**: Unlock user accounts

**Data Issues:**
- **Missing Records**: Check data import logs
- **Calculation Errors**: Verify payroll settings
- **Report Problems**: Refresh data, check filters

### System Maintenance

**Regular Maintenance:**
1. **Daily**: Monitor system performance
2. **Weekly**: Review error logs
3. **Monthly**: Database optimization
4. **Quarterly**: Security reviews

**Backup Procedures:**
1. Daily automated backups
2. Weekly full system backups
3. Monthly backup testing
4. Quarterly disaster recovery drills

### Getting Support

**Internal Support:**
1. Check system documentation
2. Review error logs
3. Test in staging environment
4. Document issues thoroughly

**External Support:**
1. Contact vendor support
2. Submit support tickets
3. Provide detailed information
4. Follow up on resolutions

---

## 📞 Emergency Procedures

### System Outages
1. Check server status
2. Notify IT support immediately
3. Communicate with users
4. Activate backup procedures
5. Document incident details

### Data Recovery
1. Identify affected data
2. Restore from recent backups
3. Verify data integrity
4. Notify affected users
5. Investigate root cause

### Security Incidents
1. Isolate affected systems
2. Change compromised passwords
3. Review security logs
4. Notify relevant authorities
5. Implement additional security measures

---

## 📚 Best Practices

### Daily Operations
1. Review pending approvals regularly
2. Monitor system performance
3. Check for security alerts
4. Update employee records promptly
5. Maintain data quality

### Monthly Tasks
1. Generate payroll reports
2. Review leave balances
3. Update organizational changes
4. Analyze attendance patterns
5. Process performance reviews

### Annual Tasks
1. Year-end payroll processing
2. Benefits enrollment
3. Performance review cycles
4. System security audits
5. Data archival procedures

---

## 📈 Advanced Features

### Automation
**Workflow Automation:**
1. Set up approval workflows
2. Automate notifications
3. Schedule report generation
4. Configure data synchronization

**Integration Options:**
1. API integrations
2. Third-party connectors
3. Data import/export
4. Real-time synchronization

### Customization
**System Customization:**
1. Custom fields
2. Branded interfaces
3. Custom reports
4. Workflow modifications

---

**Last Updated**: June 2025  
**Version**: 1.0  
**For Technical Support**: Contact IT Department  
**For HR Questions**: Contact HR Manager
