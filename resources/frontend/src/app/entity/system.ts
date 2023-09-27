export class SystemAgreement {
  id?: number = 0;
  title: string = "";
  content: string = "";
  type: number = 0;
  show: number = 0;
  created_at?: number = 0;
}

export class SystemComplaint {
  id?: number = 0;
  title: string = "";
  content?: string = "";
  type?: number = 0;
  created_at?: number = 0;
}

export class SystemConfig {
  id?: number = 0;
  key: string = "";
  value?: string = "";
  created_at?: number = 0;
}

export class Navigation {
  id?: number;

  parent_id?: number;

  navigation_name: string = "";

  navigation_link?: string = "";

  navigation_router?: string = "";

  navigation_sort?: number = 0;

  menu_show?: number = 0;

  icon?: string = "";

  select?: boolean = false;

  created_at?: string;

  updated_at?: string;

  children?: Navigation[]
}

export class Role {

  id?: number;
  role_name: string = ""
  created_at?: string;
  updated_at?: string;
  navigations?: Navigation[]
}

export class Target {
  id?: number;
  title: string = "";
  day?: number = 0;
  created_at?: number = 0;
}

export class Unit {
  id?: number;
  title: string = "";
  description?: string = "";
  label?: string = "";
  symbol?: string = "";
  finance: number = 0;
  created_at?: number = 0;
  balance?: { total_balance: number }
}

export class SystemImage {
  id?: number;
  title: string = "";
  description?: string = "";
  url?: string = "";
  created_at?: number = 0;
}

export class SystemBanner {
  id?: number;
  title: string = "";
  url?: string = "";
  relation_id: number = 0;
  relation_type: number = 0;
  position: number = 0;
  show: number = 0;
  sort_order: number = 0;
  created_at?: number = 0;
}
