import * as React from "react"

import { SearchForm } from "resources/views/components/search-form"
import { VersionSwitcher } from "resources/views/components/version-switcher"
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
} from "resources/views/components/ui/sidebar"

// Code Leap platform learning tracks
const data = {
  versions: ["v2.0 (Latest)", "v1.5", "v1.0"],
  navMain: [
    {
      title: "Learning Tracks",
      items: [
        {
          title: "Full-Stack Web Development",
          url: "/courses",
          isActive: true,
        },
        {
          title: "Python for Data & AI",
          url: "/courses",
        },
        {
          title: "PHP & Laravel Mastery",
          url: "/courses",
        },
        {
          title: "JavaScript & React Fundamentals",
          url: "/courses",
        },
      ],
    },
    {
      title: "Course Resources",
      items: [
        {
          title: "All Available Courses",
          url: "/courses",
        },
        {
          title: "Interactive Coding Labs",
          url: "/courses",
        },
        {
          title: "Course Materials & Downloads",
          url: "/courses",
        },
        {
          title: "Certificates & Achievements",
          url: "/dashboard",
        },
      ],
    },
    {
      title: "Workspace & Account",
      items: [
        {
          title: "My Learning Dashboard",
          url: "/dashboard",
        },
        {
          title: "Profile & Settings",
          url: "/settings/profile",
        },
        {
          title: "Security & Passkeys",
          url: "/settings/security",
        },
      ],
    },
  ],
}

export function AppSidebar({
  ...props
}) {
  return (
    <Sidebar {...props}>
      <SidebarHeader>
        <VersionSwitcher versions={data.versions} defaultVersion={data.versions[0]} />
        <SearchForm />
      </SidebarHeader>
      <SidebarContent>
        {data.navMain.map((item) => (
          <SidebarGroup key={item.title}>
            <SidebarGroupLabel>{item.title}</SidebarGroupLabel>
            <SidebarGroupContent>
              <SidebarMenu>
                {item.items.map((subItem) => (
                  <SidebarMenuItem key={subItem.title}>
                    <SidebarMenuButton isActive={subItem.isActive} render={<a href={subItem.url} />}>{subItem.title}</SidebarMenuButton>
                  </SidebarMenuItem>
                ))}
              </SidebarMenu>
            </SidebarGroupContent>
          </SidebarGroup>
        ))}
      </SidebarContent>
      <SidebarRail />
    </Sidebar>
  );
}

