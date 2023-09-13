export class AppBugLog {
  id?: number;
  content: string = "";
  device: number = 1;
  app_version: string = "";
  app_version_code: number = 0;
  created_at?: number = 0;
}

export class AppPublishLog {
  id?: number;
  title: string = "";
  content: string = "";
  device: number = 1;
  update_method: number = 0;
  app_version: string = "";
  app_version_code: number = 0;
  download_url: string = "";
  created_at?: number = 0;
}
