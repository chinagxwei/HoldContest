import {AppBugLog, AppPublishLog} from './app';

describe('AppBugLog', () => {
  it('should create an instance', () => {
    expect(new AppBugLog()).toBeTruthy();
  });
});

describe('AppPublishLog', () => {
  it('should create an instance', () => {
    expect(new AppPublishLog()).toBeTruthy();
  });
});
