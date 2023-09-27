import { TestBed } from '@angular/core/testing';

import { MemberVipService } from './member-vip.service';

describe('MemberVipService', () => {
  let service: MemberVipService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberVipService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
