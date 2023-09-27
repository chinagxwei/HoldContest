import { TestBed } from '@angular/core/testing';

import { MemberBanService } from './member-ban.service';

describe('MemberBanLogService', () => {
  let service: MemberBanService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberBanService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
