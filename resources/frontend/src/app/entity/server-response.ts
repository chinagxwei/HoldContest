export class ServerResponse<T> {
  code: number = -1;
  message: string = "";
  // @ts-ignore
  data: T;
}

export class Paginate<T> {
  // @ts-ignore
  current_page: number;
  // @ts-ignore
  data: T[];
  // @ts-ignore
  first_page_url: string;
  // @ts-ignore
  from: number;
  // @ts-ignore
  last_page: number;
  // @ts-ignore
  last_page_url: string;
  next_page_url?: string;
  // @ts-ignore
  path: string;
  // @ts-ignore
  per_page: number;
  prev_page_url?: string
  // @ts-ignore
  to: number;
  // @ts-ignore
  total: number;
}



