import { TestBed } from '@angular/core/testing';

import { MemberAddressService } from './member-address.service';

describe('MemberAddressService', () => {
  let service: MemberAddressService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberAddressService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
