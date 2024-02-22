import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Member, MemberAddress} from "../../entity/member";
import {
  MEMBER_ADDRESS_DELETE,
  MEMBER_ADDRESS_LIST,
  MEMBER_ADDRESS_SAVE,
  MEMBER_ADDRESS_VIEW
} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberAddressService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: MemberAddress) {
    return this.http.httpPost<Paginate<MemberAddress>>(`${MEMBER_ADDRESS_LIST}?page=${page}`, query)
  }

  public save(postData: MemberAddress) {
    return this.http.httpPost(MEMBER_ADDRESS_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberAddress>(MEMBER_ADDRESS_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(MEMBER_ADDRESS_DELETE, {id})
  }
}
