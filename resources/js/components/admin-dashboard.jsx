import React from 'react';
import { Card, CardHeader, CardTitle, CardContent } from "@components/ui/card";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@components/ui/table";
import { Badge } from "@components/ui/badge";
import { Button } from "@components/ui/button";
import { Users, GraduationCap, DollarSign, ArrowRight, ExternalLink } from "lucide-react";

export default function AdminDashboard({ stats, recentUsers = [] }) {
  return (
    <div className="space-y-8 w-full">
      <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-border pb-6">
        <div>
          <h1 className="text-3xl font-bold tracking-tight text-foreground">Admin Overview</h1>
          <p className="text-sm text-muted-foreground mt-1">Real-time telemetry and management controls for Code Leap.</p>
        </div>
        <div className="flex items-center gap-2">
          <Button variant="outline" render={<a href="/admin/users" />} className="text-xs">
            Manage Users
          </Button>
          <Button render={<a href="/admin/analytics" />} className="text-xs gap-1.5">
            View Analytics <ArrowRight className="h-3.5 w-3.5" />
          </Button>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <Card className="border-border bg-card">
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Total Users</CardTitle>
            <div className="p-2 rounded-lg bg-primary/10 text-primary">
              <Users className="h-4 w-4" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold text-foreground">{stats?.totalStudents ?? 0}</div>
            <p className="text-xs text-muted-foreground mt-1">Enrolled and active accounts</p>
          </CardContent>
        </Card>

        <Card className="border-border bg-card">
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Platform Courses</CardTitle>
            <div className="p-2 rounded-lg bg-primary/10 text-primary">
              <GraduationCap className="h-4 w-4" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold text-foreground">{stats?.activeCourses ?? 0}</div>
            <p className="text-xs text-muted-foreground mt-1">Published learning modules</p>
          </CardContent>
        </Card>

        <Card className="border-border bg-card">
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Platform Revenue</CardTitle>
            <div className="p-2 rounded-lg bg-primary/10 text-primary">
              <DollarSign className="h-4 w-4" />
            </div>
          </CardHeader>
          <CardContent>
            <div className="text-3xl font-bold text-foreground">₦{stats?.revenue || '0.00'}</div>
            <p className="text-xs text-muted-foreground mt-1">Processed transactions</p>
          </CardContent>
        </Card>
      </div>

      <Card className="border-border bg-card">
        <CardHeader className="flex flex-row items-center justify-between">
          <div>
            <CardTitle className="text-lg font-bold">Recent Registered Users</CardTitle>
            <p className="text-xs text-muted-foreground mt-0.5">Latest member activity and permissions across the platform.</p>
          </div>
          <Button variant="ghost" size="sm" render={<a href="/admin/users" />} className="text-xs gap-1">
            View All <ExternalLink className="h-3 w-3" />
          </Button>
        </CardHeader>
        <CardContent>
          <div className="rounded-lg border border-border overflow-hidden">
            <Table>
              <TableHeader className="bg-muted/50">
                <TableRow>
                  <TableHead className="text-xs font-semibold uppercase">User</TableHead>
                  <TableHead className="text-xs font-semibold uppercase">Role</TableHead>
                  <TableHead className="text-xs font-semibold uppercase">Status</TableHead>
                  <TableHead className="text-right text-xs font-semibold uppercase">Manage</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {recentUsers && recentUsers.length > 0 ? (
                  recentUsers.map((user) => (
                    <TableRow key={user.id}>
                      <TableCell className="font-medium text-foreground">{user.name}</TableCell>
                      <TableCell>
                        <Badge variant={user.role === 'admin' ? 'destructive' : (user.role === 'instructor' ? 'default' : 'secondary')} className="capitalize text-xs font-semibold">
                          {user.role}
                        </Badge>
                      </TableCell>
                      <TableCell>
                        <span className="inline-flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                          <span className="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                        </span>
                      </TableCell>
                      <TableCell className="text-right">
                        <Button variant="outline" size="sm" render={<a href="/admin/users" />} className="h-7 text-xs">
                          Edit Role
                        </Button>
                      </TableCell>
                    </TableRow>
                  ))
                ) : (
                  <TableRow>
                    <TableCell colSpan={4} className="text-center py-6 text-xs text-muted-foreground">
                      No recent users found.
                    </TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}