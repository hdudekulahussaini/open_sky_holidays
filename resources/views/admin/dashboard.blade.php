@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')


@section('content')
    <section class="welcome-card">
        <span class="accent-pill">Admin Workspace</span>
        <h2>Welcome Back, {{ auth()->user()->name }}</h2>
        <p>
            Here is your overview of Open Sky Holidays travel agency activities. 
            Track customer enquiries, update tour listings, and configure destination packages.
        </p>
    </section>

    <!-- Stats Grid -->
    <section class="stats-grid">
        <article class="stat-card">
            <div class="stat-info">
                <h3>Total Enquiries</h3>
                <div class="number">142</div>
                <span class="trend trend-up">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="3" fill="none">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                    +12.5% this week
                </span>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-info">
                <h3>Tour Packages</h3>
                <div class="number">36</div>
                <span class="trend trend-up" style="color: #0853a4;">
                    Active Packages
                </span>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-info">
                <h3>Destinations</h3>
                <div class="number">15</div>
                <span class="trend trend-up">
                    5 Country Hubs
                </span>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-info">
                <h3>Active Blogs</h3>
                <div class="number">28</div>
                <span class="trend trend-up">
                    +3 New Articles
                </span>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
            </div>
        </article>
    </section>

    <!-- Detailed Columns -->
    <div class="dashboard-two-col">
        <!-- Visual SVG Chart Container -->
        <article class="chart-container">
            <div class="chart-header">
                <h3>Booking & Enquiry Trends</h3>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background: #0853a4;"></span>
                        Enquiries
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #fbb03b;"></span>
                        Bookings
                    </div>
                </div>
            </div>

            <!-- SVG Line Graph Mockup -->
            <div style="width: 100%; display: flex; justify-content: center;">
                <svg viewBox="0 0 500 250" style="width: 100%; max-height: 220px; font-family: inherit;">
                    <!-- Gradients -->
                    <defs>
                        <linearGradient id="blueGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#0853a4" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#0853a4" stop-opacity="0.0"/>
                        </linearGradient>
                        <linearGradient id="goldGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#fbb03b" stop-opacity="0.15"/>
                            <stop offset="100%" stop-color="#fbb03b" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>

                    <!-- Y-Axis grids -->
                    <line x1="40" y1="40" x2="480" y2="40" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="40" y1="90" x2="480" y2="90" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="40" y1="140" x2="480" y2="140" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="40" y1="190" x2="480" y2="190" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="40" y1="210" x2="480" y2="210" stroke="#e2e8f0" stroke-width="2" />

                    <!-- Grid labels -->
                    <text x="15" y="45" fill="#94a3b8" font-size="10" font-weight="600">100</text>
                    <text x="15" y="95" fill="#94a3b8" font-size="10" font-weight="600">75</text>
                    <text x="15" y="145" fill="#94a3b8" font-size="10" font-weight="600">50</text>
                    <text x="15" y="195" fill="#94a3b8" font-size="10" font-weight="600">25</text>

                    <!-- X-Axis labels -->
                    <text x="45" y="232" fill="#94a3b8" font-size="10" font-weight="600">Jan</text>
                    <text x="125" y="232" fill="#94a3b8" font-size="10" font-weight="600">Feb</text>
                    <text x="205" y="232" fill="#94a3b8" font-size="10" font-weight="600">Mar</text>
                    <text x="285" y="232" fill="#94a3b8" font-size="10" font-weight="600">Apr</text>
                    <text x="365" y="232" fill="#94a3b8" font-size="10" font-weight="600">May</text>
                    <text x="445" y="232" fill="#94a3b8" font-size="10" font-weight="600">Jun</text>

                    <!-- Filled Area Enquiries -->
                    <path d="M 45 190 Q 125 100, 205 130 T 365 70 T 445 50 L 445 210 L 45 210 Z" fill="url(#blueGrad)" />
                    <!-- Line Enquiries -->
                    <path d="M 45 190 Q 125 100, 205 130 T 365 70 T 445 50" fill="none" stroke="#0853a4" stroke-width="3" stroke-linecap="round"/>

                    <!-- Filled Area Bookings -->
                    <path d="M 45 200 Q 125 160, 205 170 T 365 110 T 445 80 L 445 210 L 45 210 Z" fill="url(#goldGrad)" />
                    <!-- Line Bookings -->
                    <path d="M 45 200 Q 125 160, 205 170 T 365 110 T 445 80" fill="none" stroke="#fbb03b" stroke-width="3" stroke-linecap="round"/>

                    <!-- Data dots -->
                    <circle cx="205" cy="130" r="4" fill="#ffffff" stroke="#0853a4" stroke-width="2.5"/>
                    <circle cx="365" cy="70" r="4" fill="#ffffff" stroke="#0853a4" stroke-width="2.5"/>
                    <circle cx="445" cy="50" r="4" fill="#ffffff" stroke="#0853a4" stroke-width="2.5"/>

                    <circle cx="205" cy="170" r="4" fill="#ffffff" stroke="#fbb03b" stroke-width="2.5"/>
                    <circle cx="365" cy="110" r="4" fill="#ffffff" stroke="#fbb03b" stroke-width="2.5"/>
                    <circle cx="445" cy="80" r="4" fill="#ffffff" stroke="#fbb03b" stroke-width="2.5"/>
                </svg>
            </div>
        </article>

        <!-- Recent Activity Column -->
        <article class="recent-activity">
            <div class="recent-header">
                <h3>Recent Enquiries</h3>
                <a href="#" style="font-size: 13px; color: #0853a4; font-weight: 600;">View All</a>
            </div>

            <div class="recent-list">
                <div class="recent-item">
                    <div class="recent-client">
                        <div class="client-avatar">RS</div>
                        <div class="client-details">
                            <h4>Rajesh Sharma</h4>
                            <p>Destination: Goa (3 Nights)</p>
                        </div>
                    </div>
                    <div class="enquiry-meta">
                        <p>2 mins ago</p>
                        <span class="status status-new">New</span>
                    </div>
                </div>

                <div class="recent-item">
                    <div class="recent-client">
                        <div class="client-avatar">SJ</div>
                        <div class="client-details">
                            <h4>Sarah Jenkins</h4>
                            <p>Destination: Dubai Luxury Tour</p>
                        </div>
                    </div>
                    <div class="enquiry-meta">
                        <p>1 hour ago</p>
                        <span class="status status-contacted">Contacted</span>
                    </div>
                </div>

                <div class="recent-item">
                    <div class="recent-client">
                        <div class="client-avatar">AP</div>
                        <div class="client-details">
                            <h4>Ananya Patel</h4>
                            <p>Destination: Bangkok Explorer</p>
                        </div>
                    </div>
                    <div class="enquiry-meta">
                        <p>4 hours ago</p>
                        <span class="status status-processing">Processing</span>
                    </div>
                </div>

                <div class="recent-item">
                    <div class="recent-client">
                        <div class="client-avatar">DM</div>
                        <div class="client-details">
                            <h4>David Miller</h4>
                            <p>Destination: Singapore Getaway</p>
                        </div>
                    </div>
                    <div class="enquiry-meta">
                        <p>1 day ago</p>
                        <span class="status status-completed">Completed</span>
                    </div>
                </div>

                <div class="recent-item">
                    <div class="recent-client">
                        <div class="client-avatar">VS</div>
                        <div class="client-details">
                            <h4>Vikram Singh</h4>
                            <p>Destination: Kashmir Valley Splendor</p>
                        </div>
                    </div>
                    <div class="enquiry-meta">
                        <p>3 days ago</p>
                        <span class="status status-closed">Closed</span>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection