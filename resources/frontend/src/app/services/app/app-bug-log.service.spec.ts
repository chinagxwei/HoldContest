import { TestBed } from '@angular/core/testing';

import { AppBugLogService } from './app-bug-log.service';

describe('AppBugLogService', () => {
  let service: AppBugLogService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AppBugLogService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
