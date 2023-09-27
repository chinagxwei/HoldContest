import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {SystemImage} from "../../entity/system";
import {
  IMAGE_DELETE,
  IMAGE_LISTS,
  IMAGE_SAVE,
} from "../../config/system.url";

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<SystemImage>>(`${IMAGE_LISTS}?page=${page}`)
  }

  public save(postData: SystemImage) {
    return this.http.httpPost(IMAGE_SAVE, postData)
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(IMAGE_DELETE, {id})
  }
}
