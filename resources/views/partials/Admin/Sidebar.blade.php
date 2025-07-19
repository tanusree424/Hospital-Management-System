<div class="sidebar text-white">
    <h4 class="text-center py-4 border-bottom heading">Admin Panel</h4>

    {{-- Dashboard --}}

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        Dashboard
    </a>


    {{-- Role Management --}}
    @can('Show role')
    <a href="{{ route('role.index') }}" class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
        Role
    </a>
    @endcan

    {{-- Permission Management --}}
    @can('access_permission')
    <a href="{{ route('permission.index') }}" class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
        Permissions
    </a>
    @endcan

    {{-- User Management --}}
    @can('access_user')
    <a href="{{ route('user.index') }}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
        Users
    </a>
    @endcan

    {{-- Doctor Management --}}
    @can('View Doctors')
    <a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.index') ? 'active' : '' }}">
        Doctors
    </a>
    @endcan

    {{-- Appointment Management --}}
    @can('Appointment Show')
    <a href="{{ route('appointment.index') }}" class="{{ request()->routeIs('appointment.index') ? 'active' : '' }}">
        Appointments
    </a>
    @endcan

    {{-- Patient Management --}}
    @can('View Patient')
    <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">
        Patients
    </a>
    @endcan

    {{-- Admission & Discharge --}}
    @can('access_admission')
    <a href="{{ route('admission.index') }}" class="{{ request()->routeIs('admission.index') ? 'active' : '' }}">
        Admission / Discharge
    </a>
    @endcan

    {{-- Department Management --}}
    @can('View Department')
    <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.index') ? 'active' : '' }}">
        Departments
    </a>
    @endcan

    {{-- Medical Reports --}}
    @can('access_medical_report')
    <a href="{{ route('medical_report.index') }}" class="{{ request()->routeIs('medical_report.index') ? 'active' : '' }}">
        Medical Reports
    </a>
    @endcan

    {{-- Settings --}}
    {{-- @can('access_settings') --}}
   <a href="{{ route('admin.profile_setting') }}" class="{{ request()->routeIs('admin.profile_setting') ? 'active' : '' }}">Settings</a>



    {{-- Logout (Always Visible) --}}
    <a href="{{ route('admin.logout') }}">Logout</a>
</div>
