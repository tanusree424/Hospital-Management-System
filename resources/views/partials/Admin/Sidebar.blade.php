<div class="sidebar text-white">
    <h4 class="text-center py-4 border-bottom heading text-dark">
        @if (auth()->user()->hasRole('Admin'))
            Admin PANEL
        @elseif (auth()->user()->hasRole('Patient'))
          Patient Dashboard
        @elseif (auth()->user()->hasRole('Doctor'))
         Doctor Dashboard
        @endif
    </h4>
    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        {{-- Role Management --}}
        @can('Show role')
        <li class="nav-item">
            <a href="{{ route('role.index') }}" class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-user-shield me-2"></i> Role
            </a>
        </li>
        @endcan

        {{-- Permission Management --}}
        @can('access_permission')
        <li class="nav-item">
            <a href="{{ route('permission.index') }}" class="nav-link {{ request()->routeIs('permission.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-lock me-2"></i> Permissions
            </a>
        </li>
        @endcan

        {{-- User Management --}}
        @can('access_user')
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-users me-2"></i> Users
            </a>
        </li>
        @endcan

        {{-- Doctor Management --}}
        @can('View Doctors')
        <li class="nav-item">
            <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-user-md me-2"></i> Doctors
            </a>
        </li>
        @endcan

        {{-- Appointment Management --}}
        @can('Appointment Show')
        <li class="nav-item">
            <a href="{{ route('appointment.index') }}" class="nav-link {{ request()->routeIs('appointment.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-calendar-check me-2"></i> Appointments
            </a>
        </li>
        @endcan
         {{-- Appointment Management --}}
        @can('Appointment Show')
        <li class="nav-item">
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="bi bi-gear-fill me-2"></i> Services
            </a>
        </li>
        @endcan

        {{-- Patient Management --}}
        @can('View Patient')
        <li class="nav-item">
            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-procedures me-2"></i> Patients
            </a>
        </li>
        @endcan

        {{-- Admission & Discharge --}}
        @can('admission_discharge_access')
        <li class="nav-item">
            <a href="{{ route('admission.index') }}" class="nav-link {{ request()->routeIs('admission.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-sign-in-alt me-2"></i> Admission / Discharge
            </a>
        </li>
        @endcan

        {{-- Department Management --}}
        @can('View Department')
        <li class="nav-item">
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-building me-2"></i> Departments
            </a>
        </li>
        @endcan

        {{-- Medical Reports --}}
        @can('access_medical_report')
        <li class="nav-item">
            <a href="{{ route('medical_report.index') }}" class="nav-link {{ request()->routeIs('medical_report.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-file-medical me-2"></i> Medical Reports
            </a>
        </li>
        @endcan

        {{-- Hospital Management --}}
        @can('access_hospital_management')
        <li class="nav-item">
            <a href="{{ route('hospital.management') }}" class="nav-link {{ request()->routeIs('hospital.management') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fa fa-hospital me-2"></i> Hospital Management
            </a>
        </li>
        @endcan
        @can('Profile Setting_access')
        <li class="nav-item">
            <a href="{{ route('admin.profile_setting') }}" class="nav-link {{ request()->routeIs('admin.profile_setting') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fas fa-user me-2"></i> Profile Setting
            </a>
        </li>
        @endcan
        @can('feedback_access')
             <li class="nav-item">
            <a href="{{ route('admin.feedbacks.index') }}" class="nav-link {{ request()->routeIs('admin.feedbacks.index') ? 'active' : '' }}" style="font-size: 13px;">
                <i class="fas fa-comment-dots me-2"></i>
                 Feedback
            </a>
        </li>
        @endcan
        @can('access_blog')
             <li class="nav-item">
            <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}" style="font-size: 13px;">
               <i class="bi bi-journal-text"></i>
                 Blogs
            </a>
        </li>
        @endcan


        {{-- Logout --}}
        <li class="nav-item">
            <a href="{{ route('admin.logout') }}" class="nav-link" style="font-size: 13px;">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>
